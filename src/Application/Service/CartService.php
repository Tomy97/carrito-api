<?php

namespace App\Application\Service;

use App\Domain\Model\Cart;
use App\Domain\Model\CartProduct;
use App\Domain\Repository\CartRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    private CartRepositoryInterface $cartRepository;

    private EntityManagerInterface $entityManager;

    public function __construct(CartRepositoryInterface $cartRepository, EntityManagerInterface $entityManager)
    {
        $this->cartRepository = $cartRepository;
        $this->entityManager = $entityManager;
    }

    public function getCartService(int $userId): Cart
    {
        $cart = $this->cartRepository->findCartWithProducts($userId);
        $this->cartRepository->consolidateCartProducts($cart->getId());
        return $cart;
    }

    public function addCartService(int $userId, $product, int $quantity = 1): void
    {
        $cart = $this->cartRepository->findByUserId($userId);
        $cartProduct = new CartProduct();
        $cartProduct->setCart($cart);
        $cartProduct->setProduct($product);
        $cartProduct->setQuantity($quantity);

        $cart->addCartProduct($cartProduct);

        $this->cartRepository->save($cart);
    }

    public function removeProductToCartService(int $cartProductId): void
    {
        try {
            $this->cartRepository->removeProductToCart($cartProductId);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    public function checkoutCartService(int $userId): void
    {
        $cart = $this->cartRepository->findByUserId($userId);
        $cart->getCartProducts()->clear();
        $this->cartRepository->save($cart);
    }
}