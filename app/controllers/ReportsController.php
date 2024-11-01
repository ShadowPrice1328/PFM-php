<?php

namespace controllers;

require_once __DIR__ . "/../dtos/GenerateReportRequest.php";

use DatabaseService;
use dtos\GenerateReportRequest;
use interfaces\ICategoriesService;
use interfaces\IReportsService;
use interfaces\ITransactionsService;

class ReportsController
{
    private readonly DatabaseService $databaseService;
    private readonly ICategoriesService $categoriesService;
    private readonly ITransactionsService $transactionsService;
    private readonly IReportsService $reportsService;

    public function __construct($databaseService, $categoriesService, $transactionsService, $reportsService)
    {
        $this->databaseService = $databaseService;
        $this->categoriesService = $categoriesService;
        $this->transactionsService = $transactionsService;
        $this->reportsService = $reportsService;

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

    public function overview() : void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $withCategory = !(empty($_POST['category']));

            $request = new GenerateReportRequest();

            if (isset($_POST['category']))
                $request->category = $_POST['category'];

            $request->firstDate = date_create_from_format('Y-m-d', $_POST['firstDate']);
            $request->lastDate = date_create_from_format('Y-m-d', $_POST['lastDate']);
            $request->type = $_POST['type'];

            $model = $this->reportsService->generateReport($request, $withCategory);
        }

        $category_names = $this->transactionsService->getCategoryNamesOfTransactions();
        include_once(__DIR__ . '/../views/reports/overview.php');
    }
}