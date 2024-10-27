<?php

namespace dtos;

use entities\Category;

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
            $this->createGUID(),
            $this->name,
            $this->description
        );
    }

    private function createGUID(): string
    {
        // Create a token
        $token      = $_SERVER['HTTP_HOST'];
        $token     .= $_SERVER['REQUEST_URI'];
        $token     .= uniqid(rand(), true);

        // GUID is 128-bit hex
        $hash        = strtoupper(md5($token));

        $guid        = '';

        $guid .= substr($hash,  0,  8) .
            '-' .
            substr($hash,  8,  4) .
            '-' .
            substr($hash, 12,  4) .
            '-' .
            substr($hash, 16,  4) .
            '-' .
            substr($hash, 20, 12);

        return $guid;
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
            $errors[] = "Name cannot be blank.";
        }

        return $errors;
    }
}