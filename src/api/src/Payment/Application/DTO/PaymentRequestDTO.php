<?php
namespace App\Payment\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PaymentRequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public ?string $provider;

    #[Assert\NotBlank]
    #[Assert\Type('float')]
    public ?float $amount;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public ?string $currency;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public ?string $cardNumber;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public ?string $cardExpYear;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public ?string $cardExpMonth;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public ?string $cardCVV;

    public function __construct(
        ?string $provider = null, 
        ?float $amount = null,
        ?string $currency = null,
        ?string $cardNumber = null,
        ?string $cardExpYear = null,
        ?string $cardExpMonth = null,
        ?string $cardCVV = null,
    ) {
        $this->provider = $provider;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->cardNumber = $cardNumber;
        $this->cardExpYear = $cardExpYear;
        $this->cardExpMonth = $cardExpMonth;
        $this->cardCVV = $cardCVV;
    }
}
