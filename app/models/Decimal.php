<?php

namespace models;

use InvalidArgumentException;

class Decimal
{
    private string $value; // Store value as a string for precision

    public function __construct(string $value = '0.00')
    {
        // Validate the value to ensure it is a valid decimal, defaulting to 0.00 if empty or invalid
        if (empty($value) || !preg_match('/^\d+(\.\d{1,2})?$/', $value)) {
            $value = '0.00';
        }
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }

    // Optionally, you can add a method to return the float value
    public function toFloat(): float {
        return (float)$this->value;
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
