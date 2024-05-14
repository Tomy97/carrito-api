<?php

namespace App\Interfaces\Controller;

use App\Application\Service\CartService;
use App\Domain\Model\Cart;
use App\Domain\Model\CartProduct;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function getCart(Request $request): JsonResponse
    {
        $userId = $request->query->get('userId'); // Esto captura el userId del query string de la URL.

        if (null === $userId) {
            return new JsonResponse(['error' => 'User ID is required'], Response::HTTP_BAD_REQUEST);
        }

        $cart = $this->cartService->getCartService((int)$userId);

        if (!$cart) {
            return new JsonResponse(['error' => 'Cart not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($this->formatCart($cart));
    }

    private function formatCart(Cart $cart): array
    {
        $productsAggregated = [];

        // Iteramos sobre cada CartProduct en el carrito
        foreach ($cart->getCartProducts() as $cartProduct) {
            // Extraemos el ID único de CartProduct, que identifica cada entrada en la tabla cart_product
            $cartProductId = $cartProduct->getId();  // Este es el ID de CartProduct, no el ID de Cart

            // Agregamos un nuevo producto al arreglo de productos agregados
            $productsAggregated[] = [
                'cartProductId' => $cartProductId,  // Guardamos el ID de CartProduct
                'id' => $cartProduct->getProduct()->getId(),  // Este es el ID del producto
                'name' => $cartProduct->getProduct()->getName(),
                'price' => $cartProduct->getProduct()->getPrice() * $cartProduct->getQuantity(),
                'quantity' => $cartProduct->getQuantity(),
                'stock' => $cartProduct->getProduct()->getStock(),
                'image' => $cartProduct->getProduct()->getImageFilename(),
            ];
        }

        // Devolvemos un arreglo con el ID del carrito y la lista de productos agregados
        return [
            'id' => $cart->getId(),  // ID del carrito
            'products' => $productsAggregated  // Arreglo de productos con detalles, incluyendo el ID de CartProduct
        ];
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

    #[Route('/cart', name: 'delete_cart', methods: ['DELETE'])]
    public function removeProductFromCart(Request $request): JsonResponse
    {
        $cartProductId = $request->get('cartProductId');

        $this->cartService->removeProductToCartService($cartProductId);
        return new JsonResponse(['message' => 'Cart deleted successfuly'], status: Response::HTTP_OK);
    }

    #[Route('/cart/checkout', name: 'checkout_cart', methods: ['POST'])]
    public function checkout(Request $request): JsonResponse
    {
        $userId = $request->get('userId');
        if ($userId === null) {
            return new JsonResponse(['error' => 'User id is required'], Response::HTTP_BAD_REQUEST);
        }
        $this->cartService->checkoutCartService($userId);
        return new JsonResponse(['message' => 'Cart checked out successfuly'], status: Response::HTTP_OK);
    }
}