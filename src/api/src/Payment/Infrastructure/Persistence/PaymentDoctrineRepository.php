<?php
/**
 * Summary of namespace App\Payment\Infrastructure\Persistence
 * 
 * Not in the requirements for this task, but for future development and interactiong with DB for example.
 */
namespace App\Payment\Infrastructure\Persistence;

use App\Payment\Domain\Model\Payment;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class PaymentDoctrineRepository implements PaymentRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function save(Payment $payment): void
    {
        $this->entityManager->persist($payment);
        $this->entityManager->flush();
    }

    public function findByTransactionId(string $transactionId): ?Payment
    {
        return $this->entityManager->getRepository(Payment::class)
            ->findOneBy(['transactionId' => $transactionId]);
    }
}
