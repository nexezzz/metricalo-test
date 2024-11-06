<?php
/**
 * Summary of namespace App\Payment\Domain\Repository
 * 
 * Not in the requirements for this task, but for future development and interactiong with DB for example.
 */
namespace App\Payment\Domain\Repository;

use App\Payment\Domain\Model\Payment;

interface PaymentRepositoryInterface
{
    public function save(Payment $payment): void;
    public function findByTransactionId(string $transactionId): ?Payment;
}
