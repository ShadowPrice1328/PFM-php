<?php

//require_once(__DIR__ . '/../services/DatabaseService.php');
//require_once(__DIR__ . '/../interfaces/ICategoriesService.php');

class CategoriesController
{
    private $databaseService;
    private $categoriesService;
    public function __construct($databaseService, $categoriesService)
    {
        $this->databaseService = $databaseService;
        $this->categoriesService = $categoriesService;
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
        $categories = $this->categoriesService->getCategories();

        include_once(__DIR__ . '/../views/categories/index.php');
    }
}