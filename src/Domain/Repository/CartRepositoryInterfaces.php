<?php

namespace App\Domain\Repository;

use App\Domain\Model\Cart;

interface CartRepositoryInterface
{
    public function findByUserId($userId): ?Cart;
    public function save(Cart $cart): void;
    public function remove(Cart $cart): void;
}