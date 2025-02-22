<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/../app/controllers/HomeController.php');
require_once(__DIR__ . '/../app/controllers/CategoriesController.php');
require_once(__DIR__ . '/../app/controllers/AuthController.php');
require_once(__DIR__ . '/../app/controllers/ShopController.php');
require_once(__DIR__ . '/../app/controllers/TransactionsController.php');
require_once(__DIR__ . '/../app/controllers/ReportsController.php');
require_once(__DIR__ . '/../app/services/DatabaseService.php');
require_once(__DIR__ . '/../app/services/CategoriesService.php');
require_once(__DIR__ . '/../app/services/TransactionsService.php');
require_once(__DIR__ . '/../app/services/ReportsService.php');
require_once(__DIR__ . '/../app/services/SessionManager.php');
require_once(__DIR__ . '/../app/services/AuthService.php');
require_once(__DIR__ . '/../app/services/ProductsService.php');

use controllers\ShopController;
use controllers\AuthController;
use controllers\CategoriesController;
use controllers\HomeController;
use controllers\ReportsController;
use controllers\TransactionsController;
use services\AuthService;
use services\CartService;
use services\CategoriesService;
use services\ProductsService;
use services\ReportsService;
use services\SessionManager;
use services\TransactionsService;

SessionManager::start();

// Ініціалізація сервісів
$databaseService = new DatabaseService();
$categoriesService = new CategoriesService($databaseService->getPdo());
$transactionsService = new TransactionsService($databaseService->getPdo());
$reportsService = new ReportsService($transactionsService);
$authService = new AuthService($databaseService->getPdo());
$productsService = ProductsService::getInstance();
$cartService = new CartService();

$homeController = new HomeController($databaseService, $categoriesService, $transactionsService, $authService);
$categoriesController = new CategoriesController($databaseService, $categoriesService);
$transactionsController = new TransactionsController($databaseService, $transactionsService, $categoriesService);
$reportsController = new ReportsController($databaseService, $categoriesService, $transactionsService, $reportsService);
$authController = new AuthController($authService);
$shopController = new ShopController($databaseService, $productsService);

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
    case $request === '/register' && $_SERVER['REQUEST_METHOD'] === 'POST':
        $authController->register();
        break;
    case $request === '/register':
        $authController->index();
        break;
    case $request === '/login'  && $_SERVER['REQUEST_METHOD'] === 'POST':
        $authController->login();
        break;
    case $request === '/logout' && $_SERVER['REQUEST_METHOD'] === 'POST':
        $authController->logout();
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
    case $request === '/daily':
        $reportsController->daily();
        break;
    case $request === '/shop':
        $shopController->index();
        break;
    case $request === '/contact/submit':
        $homeController->sendEmail();
        break;
    case $request === '/add-to-cart':
        $shopController->addToCart();
        break;
    case $request === '/cart':
        $shopController->cart();
        break;
    case $request === '/update-cart':
        $shopController->updateCart();
        break;
    case $request === '/remove-from-cart':
        $shopController->removeFromCart();
        break;
    case $request === '/get-cart-info':
        $shopController->getCartInfo();
        break;
    case $request === '/delivery_form':
        $shopController->loadDeliveryForm();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/../app/views/404.php';

}
