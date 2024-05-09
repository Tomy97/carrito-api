<?php

namespace App\Application\DTO;

class CartData
{
    public $items; // Array de CartItemData
    public $total;

    public function __construct(array $items, $total)
    {
        $this->items = $items;
        $this->total = $total;
    }
}

class CartItemData
{
    public $productId;
    public $quantity;
    public $total;

    public function __construct($productId, $quantity, $total)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->total = $total;
    }
}