<?php

namespace dtos;

use entities\Product;
use models\Decimal;

class ProductResponse
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

    public function __construct(string $id, string $name, string $description, Decimal $price, int $quantity, string $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->image = $image;
    }
}

/**
 * Class for product-related extensions.
 */
class ProductExtensions
{
    public static function toProductResponse(Product $product): ProductResponse
    {
        return new ProductResponse(
            $product->id,
            $product->name,
            $product->description,
            $product->price,
            $product->quantity,
            $product->image
        );
    }
}