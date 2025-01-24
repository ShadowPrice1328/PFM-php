<?php

namespace controllers;

use DatabaseService;
use services\ProductsService;
use viewmodels\ProductViewModel;

class ShopController
{
    private DatabaseService $databaseService;
    private ProductsService $productsService;

    public function __construct(DatabaseService $databaseService, ProductsService $productsService) {
        $this->databaseService = $databaseService;
        $this->productsService = $productsService;

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
        $productsViewModel = new ProductViewModel($this->productsService->getProducts());
        include_once(__DIR__ . '/../views/shop/index.php');
    }
}