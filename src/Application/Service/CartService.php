<?php

namespace App\Application\Service;

use App\Application\DTO\CartData;
use App\Application\DTO\CartItemData;
use App\Domain\Repository\CartRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;

// class CartService
// {
//     private $cartRepository;
//     private $productRepository;

//     public function __construct(CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
//     {
//         $this->cartRepository = $cartRepository;
//         $this->productRepository = $productRepository;
//     }

//     public function getCart(): CartData
//     {
//         $cart = $this->cartRepository->getCart();
//         return new CartData($productRepository);
//     }

//     public function addProductToCart($productId): void
//     {
//         $cart = $this->cartRepository->getCart();
//         $cart->addItem(new CartItemData($productId));
//         $this->cartRepository->save($cart);
//     }

//     public function removeProductFromCart($productId): void
//     {
//         $cart = $this->cartRepository->getCart();
//         $cart->removeItem($productId);
//         $this->cartRepository->save($cart);
//     }
// }