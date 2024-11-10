<?php

namespace controllers;

require_once(__DIR__ . '/../services/CategoriesService.php');

use interfaces\IAuthService;
use services\SessionManager;

class AuthController
{
    private readonly IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index(): void
    {
        include_once(__DIR__ . '/../views/auth/index.php');
    }

    public function login() : void
    {
        header('Content-Type: application/json');

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->authService->authenticate($email, $password))
        {
            $userId = $this->authService->getUserIdByEmail($email);
            SessionManager::setUserId($userId);

            echo json_encode(['success' => true]);
        }
        else
        {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        }
    }

    public function register(): void
    {
        $email = $_POST['email'] ?? null;
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($email && $username && $password)
        {
            if ($this->authService->registerUser($email, $username, $password))
            {
                $userId = $this->authService->getUserIdByUsername($username);
                SessionManager::setUserId($userId);

                header('location: /');
                exit;
            }
        }
        else
        {
            echo "Please fill in all fields.";
        }
    }
}