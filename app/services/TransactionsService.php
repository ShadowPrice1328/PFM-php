<?php

namespace services;

use PDO;

class TransactionsService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTransactions()
    {
        $stmt = $this->pdo->query('SELECT * FROM transactions');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryNamesOfTransactions() : array
    {
        $stmt = $this->pdo->query('SELECT Category FROM transactions');
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getFilteredTransactions(string $filterBy, ?string $filterString) : array
    {
        $allTransactions = $this->getTransactions();
        $filteredTransactions = $allTransactions;

        if (!isset($filterBy) || !isset($filterString))
            return $filteredTransactions;

        switch ($filterBy)
        {
            case 'Category':
                $filteredTransactions = array_filter($allTransactions, function($t) use ($filterString) {
                    return empty($t['Category']) || strtolower($t['Category']) == strtolower($filterString);
                });
                break;

            case 'Description':
                $filteredTransactions = array_filter($allTransactions, function($t) use ($filterString) {
                   return empty($t['Description']) || strtolower($t['Description']) == strtolower($filterString);
                });
                break;

            case 'Type':
                $filteredTransactions = array_filter($allTransactions, function($t) use ($filterString) {
                    return empty($t['Type']) || strtolower($t['Type']) == strtolower($filterString);
                });
                break;

            case 'Cost':
                $filteredTransactions = array_filter($allTransactions, function($t) use ($filterString) {
                    return empty($t['Cost']) || strtolower($t['Cost']) == strtolower($filterString);
                });
                break;

            case 'Date':
                $filteredTransactions = array_filter($allTransactions, function($t) use ($filterString) {
                    return empty($t['Date']) || strtolower($t['Date']) == strtolower($filterString);
                });
                break;

            default: break;
        }

        return $filteredTransactions;
    }
}