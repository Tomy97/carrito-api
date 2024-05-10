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