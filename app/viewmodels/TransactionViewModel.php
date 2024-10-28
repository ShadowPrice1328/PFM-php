<?php

namespace viewmodels;

class TransactionViewModel
{
    public array $transactions = [];
    public array $category_names = [];

    public function __construct(array $transactions, array $category_names)
    {
        $this->transactions = $transactions;
        $this->category_names = $category_names;
    }
}