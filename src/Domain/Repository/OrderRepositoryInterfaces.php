<?php

namespace App\Domain\Repository;

use App\Domain\Model\Order;

interface OrderRepositoryInterface
{
  public function find($id): ?Order;
  public function findAll(): array;
  public function findBy(array $criteria): array;
  public function save(Order $order): void;
  public function remove(Order $order): void;
}
