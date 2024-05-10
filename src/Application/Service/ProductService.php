<?php

namespace App\Application\Service;

use App\Domain\Repository\ProductRepositoryInterface;
use App\Application\DTO\ProductData;

class ProductService
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function listProducts(): array
    {
        return array_map(function ($product) {
            return new ProductData(
                $product->getId(),
                $product->getName(),
                $product->getDescription(),
                $product->getPrice(),
                $product->getCategory(),
                $product->getStock(),
                $product->getImageFilename()
            );
        }, $this->productRepository->findAll());
    }
}