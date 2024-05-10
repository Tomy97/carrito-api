<?php

namespace App\Domain\Repository;

use App\Domain\Model\Cart;

interface CartRepositoryInterface
{
    public function getCart(): Cart;
    public function getCartData(): array;
    public function save(Cart $cart): void;
}