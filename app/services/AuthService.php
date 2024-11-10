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

    public function registerUser($email, $username, $password) : bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            'INSERT INTO users (username, email, passwordhash) VALUES (:username, :email, :passwordhash)'
        );
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':passwordhash' => $hashedPassword
        ]);
    }
}