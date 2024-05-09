<?php

namespace App\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface as RepositoryProductRepositoryInterface;

class DoctrineProductRepository extends EntityRepository implements RepositoryProductRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null): ?Product
    {
        return $this->getEntityManager()->find(Product::class, $id);
    }

    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findAll(): array
    {
        return $this->getEntityManager()->getRepository(Product::class)->findAll();
    }

    public function save(Product $product): void
    {
        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
    }

    public function remove(Product $product): void
    {
        $em = $this->getEntityManager();
        $em->remove($product);
        $em->flush();
    }
}
