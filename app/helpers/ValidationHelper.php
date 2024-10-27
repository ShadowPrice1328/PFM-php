<?php

namespace helpers;

use InvalidArgumentException;

class ValidationHelper
{
    public static function modelValidation($obj): array
    {
        $errors = [];

        // Validate ID
        if (empty($obj->id)) {
            $errors['id'] = "Id cannot be blank.";
        }

        // Validate Name
        if (empty($obj->name)) {
            $errors['name'] = "Name cannot be blank.";
        }

        // Validate Description
        if (empty($obj->description)) {
            $errors['description'] = "Description cannot be blank.";
        }

        return $errors;
    }
}