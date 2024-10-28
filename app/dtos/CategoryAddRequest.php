<?php

namespace dtos;

use entities\Category;
use models\Guid;

/**
 * Represents a DTO class for adding a Category object to the database.
 */
class CategoryAddRequest
{
    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $description;

    public function __construct(?string $name = null, ?string $description = null)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * Converts the DTO to a Category entity.
     *
     * @return Category
     */
    public function toCategory(): Category
    {
        return new Category(
            Guid::createGUID(),
            $this->name,
            $this->description
        );
    }

    /**
     * Validates the CategoryAddRequest.
     *
     * @return array An array of error messages if validation fails, empty if it passes.
     */
    public function validate(): array
    {
        $errors = [];

        if (empty($this->name)) {
            $errors['name'] = "Name cannot be blank.";
        }

        if (empty($this->description)) {
            $errors['description'] = "Description cannot be blank.";
        }

        return $errors;
    }
}