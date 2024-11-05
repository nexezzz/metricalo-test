<?php
namespace App\Tests\Payment\Unit\Controller;

use App\Payment\Application\Controller\PaymentController;
use App\Payment\Application\Resource\PaymentResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PaymentControllerTest extends TestCase
{
    private PaymentController $controller;
    private PaymentResource $paymentResource;

    protected function setUp(): void
    {
        $this->paymentResource = $this->createMock(PaymentResource::class);
        $this->controller = new PaymentController($this->paymentResource);
    }

    public static function providerData(): array
    {
        return [
            ['shift4'],
            ['aci']
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerData')]
    public function testProcessPaymentSuccess(string $provider): void
    {
        $request = new Request([], [], ['provider' => $provider], [], [], [], json_encode([
            'amount' => '10.00',
            'currency' => 'MKD',
            'card_number' => '4242424242424242',
            'card_exp_year' => '25',
            'card_exp_month' => '12',
            'card_cvv' => '123',
        ]));
        
        $this->paymentResource
            ->expects($this->once())
            ->method('processPayment')
            ->willReturn(new JsonResponse([
                'transactionId' => '123456',
                'date_of_creating' => '2024-11-04T12:34:56',
                'amount' => 499,
                'currency' => 'USD',
                'card_bin' => '4111'
            ]));

        $response = $this->controller->process($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'transactionId' => '123456',
                'date_of_creating' => '2024-11-04T12:34:56',
                'amount' => 499,
                'currency' => 'USD',
                'card_bin' => '4111'
            ]),
            $response->getContent()
        );
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerData')]
    public function testProcessPaymentFailure(string $provider): void
    {
        $request = new Request([], [], ['provider' => $provider], [], [], [], json_encode([]));

        $this->paymentResource
            ->expects($this->once())
            ->method('processPayment')
            ->willReturn(new JsonResponse([
                'status' => 'error',
                'message' => 'Invalid payment data.',
                'code' => 400
            ], 400));

        $response = $this->controller->process($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'status' => 'error',
                'message' => 'Invalid payment data.',
                'code' => 400
            ]),
            $response->getContent()
        );
    }

    public function testProcessPaymentMissingProvider(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'amount' => '10.00',
            'currency' => 'MKD',
            'card_number' => '4242424242424242',
            'card_exp_year' => '25',
            'card_exp_month' => '12',
            'card_cvv' => '123',
        ]));

        $this->paymentResource
            ->expects($this->once())
            ->method('processPayment')
            ->with($this->equalTo($request))
            ->willReturn(new JsonResponse([
                'errors' => ['provider' => ['This value should not be blank.']],
            ], 400));

        $response = $this->controller->process($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['errors' => ['provider' => ['This value should not be blank.']]]),
            $response->getContent()
        );
    }
}
