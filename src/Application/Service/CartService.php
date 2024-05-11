<?php

namespace App\Application\Service;

use App\Application\DTO\CartData;
use App\Domain\Repository\CartRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;

class CartService
{
    private UserRepositoryInterface $userRepository;
    private CartRepositoryInterface $cartRepository;
    private ProductRepositoryInterface $productRepository;

    public function __construct(UserRepositoryInterface $userRepository, CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function getCartService(int $userId): CartData
    {
        $user = $this->userRepository->findById($userId);
        $cart = $this->cartRepository->findByUserId($user->getId());
        $cartItems = $this->cartRepository->getCartItems($cart);

        $cartData = new CartData();
        $cartData->setUser($user);
        $cartData->setCartItems($cartItems);

        return $cartData;
    }
}