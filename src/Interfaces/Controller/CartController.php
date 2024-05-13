<?php

namespace App\Interfaces\Controller;

use App\Application\Service\CartService;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

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
    public function getCart(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $userId = $request->query->get('userId');
        if ($userId === null) {
            return new JsonResponse(['error' => 'User ID is required'], Response::HTTP_BAD_REQUEST);
        }

        $cart = $this->cartService->getCartService((int)$userId);

        // Serialize the cart using the 'cart_details' group
        $data = $serializer->serialize($cart, 'json', ['groups' => ['cart_details']]);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/cart', name: 'add_cart', methods: ['POST'])]
    public function addProductToCart(Request $request): JsonResponse
    {
        $userId = $request->get('userId');
        $productId = $request->get('productId');
        if ($userId === null || $productId === null) {
            return new JsonResponse(['error' => 'User id and product id are required'], Response::HTTP_BAD_REQUEST);
        }
        $product = $this->productRepository->getProduct($productId);
        $this->cartService->addCartService($userId, $product);
        return new JsonResponse(['message' => 'Product added to cart successfuly'], status: Response::HTTP_CREATED);
    }

}