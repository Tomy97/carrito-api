<?php

namespace App\Application\Service;

use App\Domain\Model\Cart;
use App\Domain\Model\CartProduct;
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
        return $this->cartRepository->findCartWithProducts($userId);
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

    public function removeProductToCartService(int $productId): void
    {
        $cartProduct = $this->cartRepository->findCartProductById($productId);
        $cart = $cartProduct->getCart();
        $cart->getCartProducts()->removeElement($cartProduct);
        $this->cartRepository->save($cart);
    }

    public function checkoutCartService(int $userId): void
    {
        $cart = $this->cartRepository->findByUserId($userId);
        $cart->getCartProducts()->clear();
        $this->cartRepository->save($cart);
    }
}