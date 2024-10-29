<?php

namespace dtos;

use entities\Transaction;
use models\Decimal;

class TransactionResponse
{
    public string $id;
    public ?string $category;
    public ?string $type;
    public Decimal $cost;
    public string $date;
    public ?string $description;
}

class TransactionExtensions
{
    public static function toTransactionResponse(Transaction $transaction): TransactionResponse
    {
        $transaction_response = new TransactionResponse();

        $transaction_response->id = $transaction->id;
        $transaction_response->category = $transaction->category;
        $transaction_response->type = $transaction->type;
        $transaction_response->cost = new Decimal($transaction->cost);
        $transaction_response->date = $transaction->date;
        $transaction_response->description = $transaction->description;

        return $transaction_response;
    }
}