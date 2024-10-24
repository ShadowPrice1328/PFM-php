<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/../app/controllers/HomeController.php');
require_once(__DIR__ . '/../app/services/DatabaseService.php');
require_once(__DIR__ . '/../app/services/CategoriesService.php');
require_once(__DIR__ . '/../app/services/TransactionsService.php');

// Ініціалізація сервісів
$databaseService = new DatabaseService();
$categoriesService = new CategoriesService($databaseService->getPdo());
$transactionsService = new TransactionsService($databaseService->getPdo());

$homeController = new HomeController($databaseService, $categoriesService, $transactionsService);

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

    default:
        http_response_code(404);
        require __DIR__ . '/../app/views/404.php';
}

//    case '/categories':
//        $categoriesService->index();
//        break;
//
//    case '/transactions':
//        $transactionsService->index();
//        break;

//$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Отримуємо параметр сторінки
//$action = isset($_GET['action']) ? $_GET['action'] : 'index'; // Отримуємо параметр дії

//switch ($page) {
//    case 'home':
//        if ($action === 'contact') {
//            $homeController->contact();
//        } else {
//            $homeController->index(); // Викликаємо метод index
//        }
//        break;
//    default:
//        $homeController->index(); // Викликаємо метод index у HomeController
//        break;
//}

