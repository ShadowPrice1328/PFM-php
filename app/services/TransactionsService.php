<?php

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
}