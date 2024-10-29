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
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCategories(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM categories');
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

        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$categoryId]);
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
        $stmt = $this->pdo->prepare('INSERT INTO categories (Id, Name, Description) VALUES (?, ?, ?)');
        $stmt->execute([$category->id, $category->name, $category->description]);

        return CategoryExtensions::toCategoryResponse($category);
    }

    public function updateCategory(CategoryUpdateRequest $request): CategoryResponse
    {
        // Update the category in the database
        $stmt = $this->pdo->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
        $stmt->execute([$request->name, $request->description, $request->id]);

        return new CategoryResponse($request->id, $request->name, $request->description);
    }

    public function deleteCategory(?string $guid): bool
    {
        if ($guid === null) {
            throw new InvalidArgumentException("GUID cannot be null.");
        }

        // Delete the category from the database
        $stmt = $this->pdo->prepare('DELETE FROM categories WHERE id = ?');
        return $stmt->execute([$guid]);
    }

    public function getFilteredCategories(string $filterBy, ?string $filterString): array
    {
        $query = 'SELECT * FROM categories';
        $params = [];

        if (!empty($filterBy) && !empty($filterString)) {
            $query .= ' WHERE ' . $filterBy . ' LIKE ?';
            $params[] = '%' . $filterString . '%';
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
        $stmt = $this->pdo->query('SELECT name FROM categories');
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function categoryExists(string $name): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM categories WHERE name = ?');
        $stmt->execute([$name]);
        return $stmt->fetchColumn() > 0;
    }
}
