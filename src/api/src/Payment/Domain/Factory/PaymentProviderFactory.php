<?php
namespace App\Payment\Domain\Factory;

use App\Payment\Domain\Provider\PaymentProviderInterface;
use InvalidArgumentException;

class PaymentProviderFactory implements PaymentProviderFactoryInterface
{
    private iterable $providers;

    private array $providerMapping = [
        'shift4' => 'App\Payment\Domain\Provider\Shift4\Shift4PaymentProvider',
        'aci' => 'App\Payment\Domain\Provider\ACI\ACIPaymentProvider',
    ];

    public function __construct(iterable $providers)
    {
        $this->providers = $providers;
    }

    public function createProvider(string $providerName): PaymentProviderInterface
    {
        $providerName = strtolower($providerName);

        if (!array_key_exists($providerName, $this->providerMapping)) {
            throw new InvalidArgumentException("Unsupported provider: $providerName");
        }
        $className = $this->providerMapping[$providerName];
        foreach ($this->providers as $provider) {
            if ($provider instanceof $className) {
                return $provider;
            }
        }

        throw new InvalidArgumentException("Provider class not found: $className");
    }
}
