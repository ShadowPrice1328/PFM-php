<?php

namespace services;

require_once __DIR__ . '/../dtos/TransactionResponse.php';
require_once __DIR__ . '/../entities/Transaction.php';
require_once __DIR__ . '/../models/Decimal.php';

use Cassandra\Date;
use dtos\TransactionAddRequest;
use dtos\TransactionExtensions;
use dtos\TransactionResponse;
use dtos\TransactionUpdateRequest;
use entities\Transaction;
use enums\TransactionTypeOptions;
use interfaces\ITransactionsService;
use InvalidArgumentException;
use models\Decimal;
use PDO;

require_once __DIR__ . '/../interfaces/ITransactionsService.php';

class TransactionsService implements ITransactionsService
{
    private PDO $pdo;
    private ?int $userId;

    public function __construct($pdo)
    {
        $this->userId = SessionManager::getUserId();

        $this->userId = SessionManager::getUserId();
        $this->pdo = $pdo;
    }

    public function getTransactions(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE userId = ?');
        $stmt->execute([$this->userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryNamesOfTransactions() : array
    {
        $stmt = $this->pdo->prepare('SELECT Category FROM transactions WHERE userId = ?');
        $stmt->execute([$this->userId]);
        $data = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($data)) {
            $stmt = $this->pdo->prepare('SELECT DISTINCT Name FROM categories WHERE userId = ?');
            $stmt->execute([$this->userId]);
            $data = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        return array_unique($data);
    }

    public function getFirstTransaction() : ?TransactionResponse
    {
        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE userId = ? ORDER BY Date ASC LIMIT 1');
        $stmt->execute([$this->userId]);

        // Fetch the result as an associative array
        $transactionData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a transaction was found
        if ($transactionData) {
            // Create and return a TransactionResponse object
            $response = new TransactionResponse();

            $response->id = $transactionData['Id'];
            $response->category = $transactionData['Category'];
            $response->type = $transactionData['Type'];
            $response->cost = new Decimal($transactionData['Cost']);
            $response->date = $transactionData['Date'];
            $response->description = $transactionData['Description'];

            return $response;
        } else
        {
            return null;
        }
    }

    public function getFilteredTransactions(string $filterBy, ?string $filterString): array {
        // Sample SQL query based on the filter
        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE ' . $filterBy . ' = ? AND userId = ?');
        $stmt->execute([$filterString, $this->userId]);
        $transactionsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Transform the associative array into Transaction objects
        $transactions = $this->transformTheAssociativeArrayIntoTransactionObjects($transactionsData);

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

        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE id = ? AND userId = ?');
        $stmt->execute([$transactionId, $this->userId]);
        $transactionData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($transactionData) {
            $transaction = new Transaction();

            $transaction->id = $transactionData['Id'];
            $transaction->category = $transactionData['Category'];
            $transaction->type = $transactionData['Type'];
            $transaction->date = $transactionData['Date'];
            $transaction->cost = new Decimal($transactionData['Cost']);
            $transaction->description = $transactionData['Description'];

            return TransactionExtensions::toTransactionResponse($transaction);
        }

        return null; // If no category is found
    }

    public function addTransaction(?TransactionAddRequest $request): TransactionResponse
    {
        if ($request === null) {
            throw new InvalidArgumentException("Transaction ID cannot be null.");
        }

        $transaction = $request->toTransaction();

        $stmt = $this->pdo->prepare('SELECT Id FROM categories WHERE Name = ?');
        $stmt->execute([$transaction->category]);
        $categoryId = $stmt->fetchColumn();

        $stmt = $this->pdo->prepare('INSERT INTO transactions (Id, Category, Type, Description, Cost, Date, UserId, CategoryId) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$transaction->id, $transaction->category, $transaction->type, $transaction->description, $transaction->cost, $transaction->date, $this->userId, $categoryId]);

        return TransactionExtensions::toTransactionResponse($transaction);
    }

    public function updateTransaction(?TransactionUpdateRequest $request): TransactionResponse
    {
        $stmt = $this->pdo->prepare('UPDATE transactions SET category = ?, type = ?, cost = ?, date = ?, description = ?, categoryId = (SELECT Id FROM categories WHERE Name = ?) WHERE id = ?');
        $stmt->execute([$request->category, $request->type->name, $request->cost, $request->date, $request->description, $request->category, $request->id]);

        return $this->getTransactionByTransactionId($request->id);
    }

    public function deleteTransaction(?string $guid): bool
    {
        if ($guid === null) {
            throw new InvalidArgumentException("GUID cannot be null.");
        }

        // Delete transaction from the database
        $stmt = $this->pdo->prepare('DELETE FROM transactions WHERE id = ? AND UserId = ?');
        return $stmt->execute([$guid, $this->userId]);
    }

    public function getTransactionBetweenTwoDates(?\DateTime $startDate, ?\DateTime $endDate): array
    {
        if ($startDate === null || $endDate === null) {
            throw new InvalidArgumentException("Start date and end date cannot be null.");
        }

        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE UserId = ? AND date BETWEEN ? AND ?');
        $stmt->execute([$this->userId, $startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);

        $transactionsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $transactions = $this->transformTheAssociativeArrayIntoTransactionObjects($transactionsData);

        return array_map(function (Transaction $transaction) {
            return TransactionExtensions::toTransactionResponse($transaction);
        }, $transactions);
    }

    /**
     * @param bool|array $transactionsData
     * @return Transaction[]
     */
    public function transformTheAssociativeArrayIntoTransactionObjects(bool|array $transactionsData): array
    {
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
        return $transactions;
    }
}