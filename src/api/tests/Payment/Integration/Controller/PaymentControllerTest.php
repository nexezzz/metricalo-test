<?php
namespace App\Tests\Payment\Integration\Controller;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PaymentControllerTest extends KernelTestCase
{
    private HttpClientInterface $httpClient;

    private array $shift4MockData = [
        'amount' => '10.00',
        'currency' => 'MKD',
        'card_number' => '4242424242424242',
        'card_exp_year' => '25',
        'card_exp_month' => '12',
        'card_cvv' => '123',
    ];

    private array $aciMockData = [
        'amount' => '10.00',
        'currency' => 'EUR',
        'card_number' => '4200000000000000',
        'card_exp_year' => '2034',
        'card_exp_month' => '05',
        'card_cvv' => '123',
    ];

    protected function setUp(): void
    {
        $this->httpClient = HttpClient::create();
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
        $response = $this->httpClient->request('POST', "http://api_app_web:80/api/payment/process/{$provider}", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($provider === 'shift4' ? $this->shift4MockData : $this->aciMockData),
        ]);

        $this->assertResponseIsSuccessful($response);
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('transactionId', $responseData);
        $this->assertArrayHasKey('date_of_creating', $responseData);
        $this->assertArrayHasKey('amount', $responseData);
        $this->assertArrayHasKey('currency', $responseData);
        $this->assertArrayHasKey('card_bin', $responseData);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerData')]
    public function testProcessPaymentFailure(string $provider): void
    {
        $response = $this->httpClient->request('POST', "http://api_app_web:80/api/payment/process/{$provider}", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([]),
        ]);

        $this->assertResponseStatusCode(400, $response);
    }

    public function testProcessPaymentMissingProvider(): void
    {
        $response = $this->httpClient->request('POST', 'http://api_app_web:80/api/payment/process/', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($this->shift4MockData),
        ]);

        $this->assertResponseStatusCode(404, $response);
    }

    private function assertResponseIsSuccessful($response): void
    {
        $this->assertTrue($response->getStatusCode() >= 200 && $response->getStatusCode() < 300);
    }

    private function assertResponseStatusCode(int $expectedStatusCode, $response): void
    {
        $this->assertEquals($expectedStatusCode, $response->getStatusCode());
    }
}
