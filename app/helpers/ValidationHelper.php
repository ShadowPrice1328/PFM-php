<?php

namespace helpers;

use InvalidArgumentException;

class ValidationHelper
{
    public static function modelValidation($obj): void
    {
        $errors = [];

        // Validate ID
        if (empty($obj->id)) {
            $errors[] = "Id cannot be blank.";
        }

        // Validate Name
        if (empty($obj->name)) {
            $errors[] = "Name cannot be blank.";
        }

        // If there are errors, throw an exception
        if (!empty($errors)) {
            throw new InvalidArgumentException(implode(" ", $errors));
        }
    }
}