<?php

namespace controllers;

require_once __DIR__ . "/../dtos/CategoryUpdateRequest.php";
require_once __DIR__ . "/../dtos/CategoryAddRequest.php";

use dtos\CategoryAddRequest;
use dtos\CategoryUpdateRequest;
use interfaces\ICategoriesService;
use services\SessionManager;

class CategoriesController
{
    private bool $authenticated;
    private $databaseService;
    private ICategoriesService $categoriesService;

    public function __construct($databaseService, $categoriesService)
    {
        $this->authenticated = \services\SessionManager::isLoggedIn();

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
        if (!SessionManager::isLoggedIn()) {
            header('Location: /');
            exit;
        }

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

            $errors = $categoryUpdateRequest->validate();

            if (empty($errors)) {
                // Update the category if no validation errors
                $updated = $this->categoriesService->updateCategory($categoryUpdateRequest);

                if ($updated) {
                    // Redirect to categories list on success
                    header("Location: /categories");
                    exit;
                } else {
                    $errors['summary'] = 'An error occurred while updating the category.';
                }
            }
        }

        include_once(__DIR__ . '/../views/categories/edit.php');
    }

    public function details(string $id) : void
    {
        $category = $this->categoriesService->getCategoryByCategoryId($id);

        if (!$category)
        {
            include_once __DIR__ . '/../views/404.php';
            return;
        }

        include_once(__DIR__ . '/../views/categories/details.php');
    }

    public function delete(string $id): void
    {
        $category = $this->categoriesService->getCategoryByCategoryId($id);

        if (!$category)
        {
            include_once __DIR__ . '/../views/404.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $deleted = $this->categoriesService->deleteCategory($id);

            if ($deleted)
            {
                header("Location: /categories");
                exit;
            }
        }

        include_once(__DIR__ . '/../views/categories/delete.php');
    }

    public function create() : void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);

            $categoryAddRequest = new CategoryAddRequest($name, $description);

            $errors = $categoryAddRequest->validate();

            if (empty($errors))
            {
                $this->categoriesService->addCategory($categoryAddRequest);
                header("Location: /categories");
                exit;
            }
        }
        include_once __DIR__ . '/../views/categories/create.php';
    }
}