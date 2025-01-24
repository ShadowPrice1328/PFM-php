<?php

namespace interfaces;

interface IProductsService
{
    /**
     * Retrives all products
     *
     * @return array
     */
    public function getProducts() : array;
}