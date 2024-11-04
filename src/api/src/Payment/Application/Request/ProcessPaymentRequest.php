<?php
namespace App\Payment\Application\Request;

use App\Payment\Application\DTO\PaymentRequestDTO;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProcessPaymentRequest
{
    private string $provider;
    private float $amount;
    private string $currency;
    private string $cardNumber;
    private string $cardExpYear;
    private string $cardExpMonth;
    private string $cardCVV;
    private ValidatorInterface $validator;

    public function __construct(
        ValidatorInterface $validator
    ) {
        $this->validator = $validator;
    }

    public function fromRequest($provider, $dto): JsonResponse|self
    {
        // Data
        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $fieldName = $violation->getPropertyPath(); 
                $errors[$fieldName][] = $violation->getMessage();
            }

            return new JsonResponse(data: ['errors' => $errors], status: 400);
        }

        $this->provider = $dto->provider;
        $this->amount = $dto->amount;
        $this->currency = $dto->currency;
        $this->cardNumber = $dto->cardNumber;
        $this->cardExpYear = $dto->cardExpYear;
        $this->cardExpMonth = $dto->cardExpMonth;
        $this->cardCVV = $dto->cardCVV;

        return $this;
    }
}
