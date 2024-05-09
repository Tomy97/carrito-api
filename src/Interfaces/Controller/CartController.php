<?php

namespace App\Interfaces\Controller;

use App\Application\Service\CartService;
use Symfony\Component\HttpFoundation\Response;

class CartController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/cart/{userId}", methods="GET")
     */
    public function getCart($userId)
    {
        $cartData = $this->cartService->getCartDetails($userId);
        return new Response(json_encode($cartData), Response::HTTP_OK);
    }
}