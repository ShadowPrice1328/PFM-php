<?php

namespace entities;

use models\Decimal;

class Transaction
{
    public string $id;
    public ?string $category;
    public ?string $type;
    public Decimal $cost;
    public string $date;
    public ?string $description;
}