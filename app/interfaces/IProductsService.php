<?php

namespace interfaces;

use entities\Product;

interface IProductsService
{
    /**
     * Retrives all products
     *
     * @return array
     */
    public function getProducts() : array;

    /**
     * Retrives product by its id
     *
     * @param string $id id of the product
     * @return ?Product
     */
    public function getProductById(string $id) : ?Product;
}