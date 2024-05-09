<?php

namespace App\Application\DTO;

class OrderData
{
    public $id;
    public $items; // Array de CartItemData
    public $total;
    public $date;

    public function __construct($id, array $items, $total, $date)
    {
        $this->id = $id;
        $this->items = $items;
        $this->total = $total;
        $this->date = $date;
    }
}