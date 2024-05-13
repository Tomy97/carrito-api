<?php

namespace App\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface;

class DoctrineProductRepository implements ProductRepositoryInterface
{

    private EntityManagerInterface $entityManager;
    private $repository;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Product::class);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function find($id): ?Product
    {
        return $this->repository->find($id);
    }

    public function findBy(array $criteria): array
    {
        return $this->repository->findBy($criteria);
    }

    public function save(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function remove(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

    public function update(Product $product): void
    {
        $this->entityManager->flush();
    }

    public function getProduct($productId): Product
    {
        return $this->repository->find($productId);
    }

    public function addProduct($product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}
