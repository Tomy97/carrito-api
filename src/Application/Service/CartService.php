<?php

namespace App\Application\Service;

use App\Domain\Model\Cart;
use App\Domain\Repository\CartRepositoryInterface;

class CartService
{
    private CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getCartService(int $userId): Cart
    {
        return $this->cartRepository->findByUserId($userId);
    }

    public function addCartService(int $userId, $product): void
    {
        $cart = $this->cartRepository->findByUserId($userId);
        $cart->addProduct($product);
        $this->cartRepository->save($cart);
    }
}