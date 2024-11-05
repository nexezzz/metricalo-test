<?php

namespace App\Tests\Payment\Unit\Command;

use App\Payment\Application\Command\ProcessPaymentCommand;
use App\Payment\Application\Resource\PaymentResource;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProcessPaymentCommandTest extends TestCase
{
    private ProcessPaymentCommand $command;
    private $paymentResource;

    protected function setUp(): void
    {
        $this->paymentResource = $this->createMock(PaymentResource::class);
        $this->command = new ProcessPaymentCommand($this->paymentResource);
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
        $this->paymentResource
            ->expects($this->once())
            ->method('processPayment')
            ->willReturn(new JsonResponse([
                'transactionId' => '123456',
                'date_of_creating' => '2024-11-04T12:34:56',
                'amount' => 499,
                'currency' => 'USD',
                'card_bin' => '4111'
            ], 200));

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['provider' => $provider]);

        $this->assertEquals(0, $commandTester->getStatusCode());
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('"transactionId"', $output);
        $this->assertStringContainsString('"date_of_creating"', $output);
        $this->assertStringContainsString('"amount"', $output);
        $this->assertStringContainsString('"currency"', $output);
        $this->assertStringContainsString('"card_bin"', $output);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerData')]
    public function testProcessPaymentFailure(string $provider): void
    {
        $this->paymentResource
            ->expects($this->once())
            ->method('processPayment')
            ->willReturn(new JsonResponse(['status' => 'error', 'message' => 'Invalid payment data.'], 400));

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['provider' => $provider]);

        $this->assertEquals(1, $commandTester->getStatusCode());
        $this->assertStringContainsString('Invalid payment data.', $commandTester->getDisplay());
    }

    public function testUnsupportedProvider(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported provider');

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['provider' => 'unsupported']);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerData')]
    public function testPaymentResourceThrowsException(string $provider): void
    {
        $this->paymentResource
            ->expects($this->once())
            ->method('processPayment')
            ->willThrowException(new \Exception('An error occurred'));

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['provider' => $provider]);

        $this->assertEquals(1, $commandTester->getStatusCode());
        $this->assertStringContainsString('Error: An error occurred', $commandTester->getDisplay());
    }
}
