<?php

namespace App\Application\DTO;

class CartData
{
    public $items; // Array de CartProduct
    public $total;

    public function __construct(array $items, $total)
    {
        $this->items = $items;
        $this->total = $total;
    }
}