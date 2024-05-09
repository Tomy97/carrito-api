<?php

namespace App\Interfaces\Controller;

use App\Application\Service\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductController 
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @Route("/products", methods="GET")
     */
    public function listProducts()
    {
        $products = $this->productService->listProducts();
        return new Response(json_encode($products), Response::HTTP_OK);
    }
}