<?php
namespace App\Payment\Domain\Factory;

use App\Payment\Domain\Provider\PaymentProviderInterface;

interface PaymentProviderFactoryInterface
{
    public function createProvider(string $providerName): PaymentProviderInterface;
}
