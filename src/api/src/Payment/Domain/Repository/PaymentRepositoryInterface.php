<?php
namespace App\Payment\Domain\Repository;

use App\Payment\Domain\Model\Payment;

interface PaymentRepositoryInterface
{
    public function save(Payment $payment): void;
    public function findByTransactionId(string $transactionId): ?Payment;
}
