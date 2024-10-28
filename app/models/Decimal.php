<?php

namespace models;

use InvalidArgumentException;

class Decimal
{
    private string $value; // Store value as a string for precision

    public function __construct(string $value)
    {
        // Optionally validate the value to ensure it is a valid decimal
        if (!preg_match('/^\d+(\.\d{1,2})?$/', $value)) {
            throw new InvalidArgumentException("Invalid decimal value.");
        }
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value; // Convert to string for display
    }

    public function add(Decimal $other): Decimal
    {
        return new Decimal(bcadd($this->value, $other->value, 2));
    }

    public function subtract(Decimal $other): Decimal
    {
        return new Decimal(bcsub($this->value, $other->value, 2));
    }

    public function multiply(Decimal $other): Decimal
    {
        return new Decimal(bcmul($this->value, $other->value, 2));
    }

    public function divide(Decimal $other): Decimal
    {
        return new Decimal(bcdiv($this->value, $other->value, 2));
    }
}
