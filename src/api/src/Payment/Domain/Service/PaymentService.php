<?php
namespace App\Payment\Domain\Service;

use App\Payment\Application\DTO\PaymentRequestDTO;
use App\Payment\Application\DTO\PaymentResponseDTO;
use App\Payment\Domain\Factory\PaymentProviderFactoryInterface;

class PaymentService
{
    public function __construct(private PaymentProviderFactoryInterface $providerFactory) {}

    public function handlePayment(PaymentRequestDTO $payment, string $providerName): PaymentResponseDTO
    {
        $provider = $this->providerFactory->createProvider($providerName);
        return $provider->processPayment(
            amount: $payment->amount, 
            currency: $payment->currency, 
            cardNumber: $payment->cardNumber, 
            cardExpMonth: $payment->cardExpMonth, 
            cardExpYear: $payment->cardExpYear, 
            cardCVV: $payment->cardCVV
        );
    }
}
