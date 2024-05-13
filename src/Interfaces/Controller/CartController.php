<?php

namespace App\Interfaces\Controller;

use App\Application\Service\CartService;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private CartService $cartService;

    private ProductRepositoryInterface $productRepository;

    public function __construct(CartService $cartService, ProductRepositoryInterface $productRepository)
    {
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }

    #[Route('/cart', name: 'get_cart', methods: ['GET'])]
    public function getCart(Request $request): JsonResponse
    {
        $userId = $request->query->get('userId');
        if ($userId === null) {
            return new JsonResponse(['error' => 'User id es requerido'], Response::HTTP_BAD_REQUEST);
        }

        $cart = $this->cartService->getCartService((int) $userId);

        return new JsonResponse([
            'cartId' => $cart->getId(),
            'products' => $cart->getProducts()
        ], Response::HTTP_OK);
    }

    #[Route('/cart', name: 'app_cart', methods: ['POST'])]
    public function addProductToCart(Request $request): JsonResponse
    {
        $userId = $request->get('userId');
        $productId = $request->get('productId');
        $product = $this->productRepository->getProduct($productId);
        $this->cartService->addCartService($userId, $product);
        return new JsonResponse(['message' => 'Product added to cart'], Response::HTTP_CREATED);
    }

}