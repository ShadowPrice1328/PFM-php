<?php

namespace services;

require_once __DIR__ . '/../dtos/TransactionResponse.php';
require_once __DIR__ . '/../entities/Transaction.php';
require_once __DIR__ . '/../models/Decimal.php';

use dtos\TransactionAddRequest;
use dtos\TransactionExtensions;
use dtos\TransactionResponse;
use dtos\TransactionUpdateRequest;
use entities\Transaction;
use interfaces\ITransactionsService;
use InvalidArgumentException;
use models\Decimal;
use PDO;

require_once __DIR__ . '/../interfaces/ITransactionsService.php';

class TransactionsService implements ITransactionsService
{
    private PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTransactions(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM transactions');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryNamesOfTransactions() : array
    {
        $stmt = $this->pdo->query('SELECT Category FROM transactions');
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getFilteredTransactions(string $filterBy, ?string $filterString): array {
        // Sample SQL query based on the filter
        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE ' . $filterBy . ' LIKE ?');
        $stmt->execute(["%$filterString%"]);
        $transactionsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Transform the associative array into Transaction objects
        $transactions = array_map(function ($transactionData) {
            $transaction = new Transaction();

            $transaction->id = $transactionData['Id'];
            $transaction->category = $transactionData['Category'];
            $transaction->type = $transactionData['Type'];
            $transaction->cost = new Decimal($transactionData['Cost']);
            $transaction->date = $transactionData['Date'];
            $transaction->description = $transactionData['Description'];

            return $transaction;
        }, $transactionsData);

        // Transform Transaction objects into TransactionResponse objects
        return array_map(function (Transaction $transaction) {
            return TransactionExtensions::toTransactionResponse($transaction);
        }, $transactions);
    }


    public function getTransactionByTransactionId(?string $transactionId): ?TransactionResponse
    {
        if ($transactionId === null) {
            throw new InvalidArgumentException("Category ID cannot be null.");
        }

        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE id = ?');
        $stmt->execute([$transactionId]);
        $transaction = $stmt->fetch(PDO::FETCH_ASSOC);

        return $transaction ? TransactionExtensions::toTransactionResponse($transaction) : null;
    }

    public function addTransaction(?TransactionAddRequest $request): TransactionResponse
    {
        if ($request === null) {
            throw new InvalidArgumentException("Transaction ID cannot be null.");
        }

        $transaction = $request->toTransaction();

        $stmt = $this->pdo->prepare('INSERT INTO transactions (Id, Category, Type, Description, Cost, Date) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$transaction->id, $transaction->category, $transaction->type, $transaction->description, $transaction->cost, $transaction->date]);

        return TransactionExtensions::toTransactionResponse($transaction);
    }

    public function updateTransaction(?TransactionUpdateRequest $request): TransactionResponse
    {
        // TODO: Implement updateTransaction() method.
    }

    public function deleteTransaction(?string $guid): bool
    {
        // TODO: Implement deleteTransaction() method.
    }

    public function getTransactionBetweenTwoDates(?string $startDate, ?string $endDate): array
    {
        // TODO: Implement getTransactionBetweenTwoDates() method.
    }
}