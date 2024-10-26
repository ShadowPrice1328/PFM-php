<?php

require_once(__DIR__ . '/../services/DatabaseService.php');
require_once(__DIR__ . '/../services/CategoriesService.php');
require_once(__DIR__ . '/../services/TransactionsService.php');

class HomeController
{
    private $databaseService;
    private $categoriesService;
    private $transactionsService;

    public function __construct($databaseService, $categoriesService, $transactionsService)
    {
        $this->databaseService = $databaseService;
        $this->categoriesService = $categoriesService;
        $this->transactionsService = $transactionsService;
    }

    public function index()
    {
        $viewModel = [];

        // Check database connection
        list($isConnected, $errorMessage) = $this->databaseService->canConnect();

        if ($isConnected) {
            $viewModel['connectionStatus'] = 'Connected to database!';
            $viewModel['categories'] = $this->categoriesService->getCategories();
            $viewModel['transactions'] = $this->transactionsService->getTransactions();
        } else {
            $viewModel['connectionStatus'] = 'Connection error!';
            $viewModel['errorMessage'] = $errorMessage;
        }

        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0775, true);
        }
        file_put_contents($logDir . '/debug.log', print_r($viewModel, true), FILE_APPEND);
        // Pass data to the view
        include_once(__DIR__ . '/../views/home/index.php');
    }

    public function contact()
    {
        include_once(__DIR__ . '/../views/home/contact.php');
    }
}