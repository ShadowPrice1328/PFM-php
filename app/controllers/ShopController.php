<?php

namespace controllers;

use DatabaseService;

class ShopController
{
    private DatabaseService $databaseService;

    public function __construct(DatabaseService $databaseService) {
        $this->databaseService = $databaseService;

        $this->checkDatabaseConnection();
    }

    protected function checkDatabaseConnection(): void
    {
        list($isConnected, $errorMessage) = $this->databaseService->canConnect();

        if (!$isConnected) {
            // Redirect to home page if not connected
            header("Location: /");
            exit;
        }
    }

    public function index(): void
    {
        include_once(__DIR__ . '/../views/shop/index.php');
    }
}