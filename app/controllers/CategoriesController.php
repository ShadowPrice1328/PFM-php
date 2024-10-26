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

    public function search(?string $categoryName): void
    {
        // Initialize the message
        $message = "";

        // Trim and lower case the category name if it's not empty
        if (!empty($categoryName)) {
            $categoryName = trim(strtolower($categoryName));

            // Fetch filtered categories
            $categories = $this->categoriesService->getFilteredCategories('Name', $categoryName);

            if (empty($categories)) {
                // Handle the case where no results are found
                $message = "Nothing's found";
            }
        }

        // Include the layout but focus on the content part
        ob_start();
        include_once(__DIR__ . '/../partialViews/categories_partial.php'); // Assuming this includes the categories table
        $content = ob_get_clean();

        // Return the content as JSON
        header('Content-Type: application/json');
        echo json_encode(['content' => $content, 'message' => $message]);
        exit; // Terminate the script
    }

}