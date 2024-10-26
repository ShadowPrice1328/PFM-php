<?php

namespace dtos;

use entities\Category;

/**
 * Represents a DTO for responses from category-related operations.
 */
class CategoryResponse
{
    public string $id;
    public ?string $name;
    public ?string $description;

    public function __construct(string $id, ?string $name = null, ?string $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function toUpdateRequest(): CategoryUpdateRequest
    {
        return new CategoryUpdateRequest(
            $this->id,
            $this->name,
            $this->description
        );
    }
}

/**
 * Class for category-related extensions.
 */
class CategoryExtensions
{
    public static function toCategoryResponse(Category $category): CategoryResponse
    {
        return new CategoryResponse(
            $category->id,
            $category->name,
            $category->description
        );
    }
}