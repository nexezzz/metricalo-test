<?php
namespace App\Payment\Domain\Provider;

use App\Payment\Application\DTO\PaymentResponseDTO;

interface PaymentProviderInterface
{
    public function processPayment(
        float $amount,
        string $currency,
        string $cardNumber,
        string $cardExpMonth,
        string $cardExpYear,
        string $cardCVV
    ): PaymentResponseDTO;
}
