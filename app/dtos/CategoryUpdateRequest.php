<?php

namespace dtos;

use entities\Category;
use InvalidArgumentException;

/**
 * Represents a DTO class for category updating.
 */
class CategoryUpdateRequest
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

    public function __construct(string $id, ?string $name = null, ?string $description = null)
    {
        $this->id = $id;
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
            $this->id,
            $this->name,
            $this->description
        );
    }

    /**
     * Validates the CategoryUpdateRequest.
     *
     * @return array An array of error messages if validation fails, empty if it passes.
     * @throws InvalidArgumentException if validation fails.
     */
    public function validate(): array
    {
        $errors = [];

        if (empty($this->id)) {
            $errors[] = "Id cannot be blank.";
        }

        if (empty($this->name)) {
            $errors[] = "Name cannot be blank.";
        }

        if (!empty($errors)) {
            throw new InvalidArgumentException(implode(", ", $errors));
        }

        return $errors;
    }
}