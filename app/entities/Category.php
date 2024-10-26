<?php

namespace entities;

/**
 * Domain model for Category.
 */
class Category
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

    public function __construct(string $id, string $name, ?string $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }
}
