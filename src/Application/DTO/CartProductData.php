<?php

namespace App\Application\DTO;

class CartProductData
{
    public $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }
}
