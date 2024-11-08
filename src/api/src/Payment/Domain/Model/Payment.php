<?php 
/**
 * Summary of namespace App\Payment\Domain\Model
 * 
 * Not in the requirements for this task, but for future development and interactiong with DB for example.
 */
namespace App\Payment\Domain\Model;

class Payment
{
    public function __construct(
        private float $amount, 
        private string $transactionId,
        private string $currency,
        private string $dateOfCreating,
        private string $cardBin,

    ) {
        //
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDateOfCreating(): string
    {
        return $this->dateOfCreating;
    }

    public function getCardBin(): string
    {
        return $this->cardBin;
    }
}
