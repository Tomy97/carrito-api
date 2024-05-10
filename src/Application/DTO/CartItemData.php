<?php

namespace App\Application\DTO;

class CartItemData
{
    public $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }
}
