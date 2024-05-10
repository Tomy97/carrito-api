<?php

namespace App\Application\DTO;

class ProductData
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $category;
    public $stock;
    public $imageFilename;


    public function __construct($id, $name, $description, $price, $category, $stock, $imageFilename)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->stock = $stock;
        $this->imageFilename = $imageFilename;
    }
}