<?php
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
