<?php

namespace App\Domain\Repository;

use App\Domain\Model\Cart;

interface CartRepositoryInterface
{
    public function findByUserId($userId): Cart;

    public function save(Cart $cart): void;

    public function delete(Cart $cart): void;

    public function findAll(): array;

    public function findOneBy(): Cart;

    public function getProducts(): array;

    public function addProduct($product): void;

    public function removeProduct($product): void;

    public function getTotal(): float;

    public function getId(): int;
}