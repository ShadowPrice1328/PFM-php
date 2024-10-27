<?php

require_once __DIR__ . "/../dtos/CategoryUpdateRequest.php";

use dtos\CategoryUpdateRequest;
use helpers\ValidationHelper;

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

    public function edit(string $id) : void
    {
        $category = $this->categoriesService->getCategoryByCategoryId($id);
        $errors = [];

        if (!$category)
        {
            include_once __DIR__ . '/../views/404.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $id = $_POST['id'];

            $categoryUpdateRequest = new CategoryUpdateRequest($id, $name, $description);

            // Validate using ValidationHelper
            $errors = ValidationHelper::modelValidation($categoryUpdateRequest);

            if (empty($errors)) {
                // Update the category if no validation errors
                $updated = $this->categoriesService->updateCategory($categoryUpdateRequest);

                if ($updated) {
                    // Redirect to categories list on success
                    header("Location: /categories");
                    exit;
                } else {
                    var_dump($errors);

                    $errors['summary'] = 'An error occurred while updating the category.';
                }
            }
        }

        include_once(__DIR__ . '/../views/categories/edit.php');
    }

}