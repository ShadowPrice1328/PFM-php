<?php
require_once (__DIR__. '/../../config/config.php');

class DatabaseService
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS']
            );
            // Set PDO's attributes for error handling
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function canConnect()
    {
        try {
            $this->pdo->query('SELECT 1');
            return [true, null];
        } catch (Exception $e) {
            return [false, $e->getMessage()];
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
