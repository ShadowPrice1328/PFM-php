<?php

namespace interfaces;

use dtos\CategoryAddRequest;
use dtos\CategoryResponse;
use dtos\CategoryUpdateRequest;

interface ICategoriesService
{
    /**
     * Retrieves all categories present in the database.
     *
     * @return CategoryResponse[] A list of CategoryResponse objects.
     */
    public function getCategories(): array;

    /**
     * Retrieves a specific category by its ID.
     *
     * @param string|null $categoryId The ID of the category to retrieve.
     * @return CategoryResponse|null A CategoryResponse with information about the selected category, or null if not found.
     */
    public function getCategoryByCategoryId(?string $categoryId): ?CategoryResponse;

    /**
     * Adds a new category to the database.
     *
     * @param CategoryAddRequest|null $request The category to add.
     * @return CategoryResponse The same details but with the generated ID.
     */
    public function addCategory(?CategoryAddRequest $request): CategoryResponse;

    /**
     * Updates information about a category.
     *
     * @param CategoryUpdateRequest $request The category to update.
     * @return CategoryResponse A CategoryResponse with updated information about the category.
     */
    public function updateCategory(CategoryUpdateRequest $request): CategoryResponse;

    /**
     * Removes a category from the database.
     *
     * @param string|null $guid The ID of the category to remove.
     * @return bool True if successful, false if an error occurred.
     */
    public function deleteCategory(?string $guid): bool;

    /**
     * Retrieves all categories that match filter parameters.
     *
     * @param string $filterBy The field to filter by.
     * @param string|null $filterString The string to filter with.
     * @return CategoryResponse[] A list of filtered CategoryResponses.
     */
    public function getFilteredCategories(string $filterBy, ?string $filterString): array;

    /**
     * Retrieves the names of every category.
     *
     * @return string[] A list of category names.
     */
    public function getCategoryNames(): array;
}