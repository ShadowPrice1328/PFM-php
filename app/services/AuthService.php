<?php

namespace services;

use interfaces\IAuthService;
use PDO;

class AuthService implements IAuthService
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function authenticate($username, $password): bool
    {
        $stmt = $this->pdo->prepare("SELECT PasswordHash FROM users WHERE username = ?");
        $stmt->execute([$username]);

        $hashedPassword = $stmt->fetchColumn();

        if (password_verify($password, $hashedPassword)) {
            return true;
        }

        return false;
    }

    public function getUserIdByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchColumn();
    }
}