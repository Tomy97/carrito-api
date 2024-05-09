<?php

namespace App\Application\Service;

use App\Application\DTO\CartData;
use App\Application\DTO\CartItemData;
use App\Domain\Repository\CartRepositoryInterface;

class CartService
{
    private $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getCartDetails($userId)
    {
        $cart = $this->cartRepository->findByUserId($userId);
        return new CartData(array_map(function ($item) {
            return new CartItemData($item->getProduct()->getId(), $item->getQuantity(), $item->getTotal());
        }, $cart->getItems()), $cart->getTotal());
    }
}