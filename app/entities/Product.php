<?php

namespace entities;

use models\Decimal;

class Product
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $description;

    /**
     * @var Decimal
     */
    public Decimal $price;

    /**
     * @var int
     */
    public int $quantity;

    /**
     * @var string
     */
    public string $image;
}