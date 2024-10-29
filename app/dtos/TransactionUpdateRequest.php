<?php

namespace dtos;

use entities\Transaction;
use enums\TransactionTypeOptions;
use models\Decimal;

class TransactionUpdateRequest
{
    public string $id;
    public ?string $category;
    public ?TransactionTypeOptions $type;
    public Decimal $cost;
    public string $date;
    public ?string $description;

    public function __construct(string $id, string $category, TransactionTypeOptions $type, Decimal $cost, string $date, string $description)
    {
        $this->id = $id;
        $this->category = $category;
        $this->type = $type;
        $this->cost = $cost;
        $this->date = $date;
        $this->description = $description;
    }

    public function toTransaction() : Transaction
    {
        $transaction = new Transaction();

        $transaction->id = $this->id;
        $transaction->category = $this->category;
        $transaction->type = $this->type;
        $transaction->cost = $this->cost;
        $transaction->date = $this->date;
        $transaction->description = $this->description;

        return $transaction;
    }

    public function validate() : array
    {
        $errors = [];

        if (empty($this->id)) {
            $errors['id'] = "Id is required";
        }
        if (empty($this->category)) {
            $errors['category'] = "Category is required";
        }
        if (empty($this->type)) {
            $errors['type'] = "Type is required";
        }
        if (empty($this->cost)) {
            $errors['cost'] = "Cost is required";
        }
        if (preg_match("^\d+([.,]\d{1,2})?$", $this->cost) === 0)
        {
            $errors['cost-regex'] = "Invalid input";
        }
        if (empty($this->date)) {
            $errors['date'] = "Date is required";
        }

        return $errors;
    }
}