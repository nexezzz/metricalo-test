<?php

namespace App\Payment\Application\DTO;

class PaymentResponseDTO
{
    public function __construct(
        private string $transactionId,
        private \DateTimeInterface $createdAt,
        private float $amount,
        private string $currency,
        private string $cardBin
    ) {}

    // Getters
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCardBin(): string
    {
        return $this->cardBin;
    }

    // Converts the DTO to an array for JSON responses
    public function toArray(): array
    {
        return [
            'transaction_id' => $this->transactionId,
            'date_of_creation' => $this->createdAt->format('Y-m-d H:i:s'),
            'amount' => $this->amount,
            'currency' => $this->currency,
            'card_bin' => $this->cardBin,
        ];
    }
}
