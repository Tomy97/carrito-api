<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Cart;
use App\Domain\Repository\CartRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineCartRepository implements CartRepositoryInterface
{

    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Cart::class);
    }

    public function save(Cart $cart): void
    {
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    public function delete(Cart $cart): void
    {
        $this->entityManager->remove($cart);
        $this->entityManager->flush();
    }

    public function findByUserId($userId): Cart
    {
        return $this->findOneBy(['userId' => $userId]);
    }

    public function findOneBy(): Cart
    {
        return $this->findOneBy();
    }

    public function findAll(): array
    {
        return $this->findAll();
    }
}
