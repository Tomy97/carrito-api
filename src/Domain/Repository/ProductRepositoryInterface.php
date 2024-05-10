<?php

namespace App\Domain\Repository;

use App\Domain\Model\Product;

interface ProductRepositoryInterface
{
    public function find($id): ?Product;
    public function findAll(): array;
    public function findBy(array $criteria): array;
    public function save(Product $product): void;
    public function remove(Product $product): void;
}