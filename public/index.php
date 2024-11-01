<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/../app/controllers/HomeController.php');
require_once(__DIR__ . '/../app/controllers/CategoriesController.php');
require_once(__DIR__ . '/../app/controllers/AuthController.php');
require_once(__DIR__ . '/../app/controllers/TransactionsController.php');
require_once(__DIR__ . '/../app/controllers/ReportsController.php');
require_once(__DIR__ . '/../app/services/DatabaseService.php');
require_once(__DIR__ . '/../app/services/CategoriesService.php');
require_once(__DIR__ . '/../app/services/TransactionsService.php');
require_once(__DIR__ . '/../app/services/ReportsService.php');


use controllers\AuthController;
use controllers\CategoriesController;
use controllers\HomeController;
use controllers\ReportsController;
use controllers\TransactionsController;
use services\CategoriesService;
use services\ReportsService;
use services\TransactionsService;

// Ініціалізація сервісів
$databaseService = new DatabaseService();
$categoriesService = new CategoriesService($databaseService->getPdo());
$transactionsService = new TransactionsService($databaseService->getPdo());
$reportsService = new ReportsService($transactionsService);

$homeController = new HomeController($databaseService, $categoriesService, $transactionsService);
$categoriesController = new CategoriesController($databaseService, $categoriesService);
$transactionsController = new TransactionsController($databaseService, $transactionsService, $categoriesService);
$reportsController = new ReportsController($databaseService, $categoriesService, $transactionsService, $reportsService);
$authController = new AuthController();

// Отримуємо шлях запиту без параметрів
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Видаляємо .php, якщо воно присутнє
$requestUri = preg_replace('/\.php$/', '', $requestUri);

$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$request = str_replace($scriptName, '', $requestUri);
$request = '/' . trim($request, '/');

// Маршрутизація на основі запиту
switch ($request) {
    case '':
    case '/':
    case '/home':
        $homeController->index();
        break;

    case '/contact':
        $homeController->contact();
        break;
    case '/categories':
        $categoriesController->index();
        break;
    case (preg_match('/^\/categories\/search\/(.+)$/', $request) ? $request : false):
        // Extract the category name from the URL
        preg_match('/^\/categories\/search\/(.+)$/', $request, $matches);
        $categoryName = $matches[1]; // The category name from the URL
        $categoriesController->search($categoryName);
        break;
    case $request === '/categories/edit' && isset($_GET['id']):
        $categoriesController->edit($_GET['id']);
        break;
    case $request === '/categories/details' && isset($_GET['id']):
        $categoriesController->details($_GET['id']);
        break;
    case $request === '/categories/delete' && isset($_GET['id']):
        $categoriesController->delete($_GET['id']);
        break;
    case $request === '/categories/create':
        $categoriesController->create();
        break;
    case $request === '/register':
        $authController->index();
        break;
    case $request === '/transactions':
        $transactionsController->index();
        break;
    case $request === '/transactions/create':
        $transactionsController->create();
        break;
    case $request === '/transactions/filter':
        // Get the filterBy and filterString parameters from the request
        $filterBy = $_GET['filterBy'] ?? null;  // Use GET to retrieve query parameters
        $filterString = $_GET['filterString'] ?? null; // Optional filter string
        // Call the filter_by method with the parameters
        $transactionsController->filter($filterBy, $filterString);
        break;
    case $request === '/transactions/edit' && isset($_GET['id']):
        $transactionsController->edit($_GET['id']);
        break;
    case $request === '/transactions/details' && isset($_GET['id']):
        $transactionsController->details($_GET['id']);
        break;
    case $request === '/transactions/delete' && isset($_GET['id']):
        $transactionsController->delete($_GET['id']);
        break;
    case $request === '/overview':
        $reportsController->overview();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/../app/views/404.php';

}
