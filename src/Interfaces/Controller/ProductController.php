<?php

namespace App\Interfaces\Controller;

use App\Application\Service\ProductService;
use App\Domain\Model\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Infrastructure\Repository\DoctrineProductRepository;


class ProductController extends AbstractController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    #[Route('/products', name: 'app_products')]
    public function productList(): Response
    {
        $products = $this->productService->listProducts();
        return new JsonResponse($products);
    }
}
