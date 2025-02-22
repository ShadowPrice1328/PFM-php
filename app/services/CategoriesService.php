<?php

namespace services;

require_once __DIR__ . '/../dtos/CategoryResponse.php';
require_once __DIR__ . '/../entities/Category.php';

use dtos\CategoryAddRequest;
use dtos\CategoryExtensions;
use dtos\CategoryResponse;
use dtos\CategoryUpdateRequest;
use entities\Category;
use interfaces\ICategoriesService;
use InvalidArgumentException;
use PDO;

require_once __DIR__ . '/../interfaces/ICategoriesService.php';

class CategoriesService implements ICategoriesService
{
    private ?int $userId;
    // TO DO: USE SESSION MANAGER HERE TO OBTAIN USER'S ID

    private $pdo;

    public function __construct($pdo)
    {
        $this->userId = SessionManager::getUserId();
        $this->pdo = $pdo;
    }

    public function getCategories(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE userid = ?');
        $stmt->execute([SessionManager::getUserId()]);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($cat) {
            $category = new Category($cat['Id'], $cat['Name'], $cat['Description']);
            return CategoryExtensions::toCategoryResponse($category); // Use the existing method
        }, $categories);
    }

    public function getCategoryByCategoryId(?string $categoryId): ?CategoryResponse
    {
        if ($categoryId === null) {
            throw new InvalidArgumentException("Category ID cannot be null.");
        }

        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = ? AND userid = ?');
        $stmt->execute([$categoryId, $this->userId]);
        $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($categoryData) {
            $category = new Category($categoryData['Id'], $categoryData['Name'], $categoryData['Description']);

            return CategoryExtensions::toCategoryResponse($category);
        }

        return null; // If no category is found
    }

    public function addCategory(?CategoryAddRequest $request): CategoryResponse
    {
        if ($request === null) {
            throw new InvalidArgumentException("Request cannot be null.");
        }

        // Check for existing category
        if ($this->categoryExists($request->name)) {
            throw new InvalidArgumentException("This category already exists.");
        }

        // Transform AddRequest to Category domain model
        $category = $request->toCategory();

        // Insert category into the database
        $stmt = $this->pdo->prepare('INSERT INTO categories (Id, Name, Description, UserId) VALUES (?, ?, ?, ?)');
        $stmt->execute([$category->id, $category->name, $category->description, $this->userId]);

        return CategoryExtensions::toCategoryResponse($category);
    }

    public function updateCategory(CategoryUpdateRequest $request): CategoryResponse
    {
        // Getting old category name from database
        $stmt = $this->pdo->prepare('SELECT Name FROM Categories WHERE Id = ? AND UserId = ?');
        $stmt->execute([$request->id, $this->userId]);
        $old_category_name = $stmt->fetchColumn();

        // Update the category in the database
        $stmt = $this->pdo->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ? AND UserId = ?');
        $stmt->execute([$request->name, $request->description, $request->id, $this->userId]);

        // Update the transactions table to match the new category name
        $stmt = $this->pdo->prepare('UPDATE transactions SET category = ? WHERE category = ? AND userid = ?');
        $stmt->execute([$request->name, $old_category_name, $this->userId]);

        return new CategoryResponse($request->id, $request->name, $request->description);
    }

    public function deleteCategory(?string $guid): bool
    {
        if ($guid === null) {
            throw new InvalidArgumentException("GUID cannot be null.");
        }

        // Delete related transactions
        $stmt = $this->pdo->prepare('DELETE FROM transactions WHERE CategoryId = ? AND userid = ?');
        $stmt->execute([$guid, $this->userId]);

        // Delete the category from the database
        $stmt = $this->pdo->prepare('DELETE FROM categories WHERE id = ? AND userid = ?');
        return $stmt->execute([$guid, $this->userId]);
    }

    public function getFilteredCategories(string $filterBy, ?string $filterString): array
    {
        $query = 'SELECT * FROM categories WHERE UserId = ' . $this->userId;
        $params = [];

        if (!empty($filterBy) && !empty($filterString)) {
            $query .= ' AND ' . $filterBy . ' LIKE ?';
            $params[] = $filterString . '%';
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($cat) {
            return new CategoryResponse($cat['Id'], $cat['Name'], $cat['Description']);
        }, $categories);
    }

    public function getCategoryNames(): array
    {
        $stmt = $this->pdo->query('SELECT name FROM categories WHERE UserId = ' . $this->userId);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function categoryExists(string $name): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM categories WHERE name = ? AND UserId = ?');
        $stmt->execute([$name, $this->userId]);
        return $stmt->fetchColumn() > 0;
    }
}
