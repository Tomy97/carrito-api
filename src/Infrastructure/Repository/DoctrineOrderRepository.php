<?php

namespace App\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use App\Domain\Model\Order;
use App\Domain\Model\OrderRepositoryInterface;

class DoctrineProductRepository extends EntityRepository implements OrderRepositoryInterface
{

    public function find($id, $lockMode = null, $lockVersion = null): ?Order
    {
        return $this->getEntityManager()->find(Order::class, $id);
    }

    public function findAll(): array
    {
        return $this->getEntityManager()->getRepository(Order::class)->findAll();
    }

    public function findBy(
        array $criteria,
        ?array $orderBy = null,
        $limit = null,
        $offset = null
    ): array {
        return $this->getEntityManager()->getRepository(Order::class)->findBy($criteria);
    }

    public function save(Order $order): void
    {
        $em = $this->getEntityManager();
        $em->persist($order);
        $em->flush();
    }

    public function remove(Order $order): void
    {
        $em = $this->getEntityManager();
        $em->remove($order);
        $em->flush();
    }
}
