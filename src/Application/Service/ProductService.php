<?php

namespace App\Application\Service;

use App\Domain\Repository\ProductRepositoryInterface;
use App\Application\DTO\ProductData;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function listProducts()
    {
        return array_map(function ($product) {
            return new ProductData($product->getId(), $product->getName(), $product->getDescription(), $product->getPrice());
        }, $this->productRepository->findAll());
    }
}