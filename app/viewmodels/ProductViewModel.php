<?php

namespace viewmodels;

class ProductViewModel
{
    public array $products = [];

    public function __construct(array $products)
    {
        $this->products = $products;
    }
}