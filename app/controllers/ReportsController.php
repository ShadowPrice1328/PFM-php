<?php

namespace controllers;

require_once __DIR__ . "/../dtos/GenerateReportRequest.php";

use DatabaseService;
use DateTime;
use dtos\GenerateReportRequest;
use dtos\GenerateReportResponse;
use interfaces\ICategoriesService;
use interfaces\IReportsService;
use interfaces\ITransactionsService;
use services\SessionManager;

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

    private function generateChartTitle(GenerateReportResponse $model): string
    {
        return $model->type . " from " . $model->firstDate->format('Y-m-d') . " to " . $model->lastDate->format('Y-m-d');
    }

    public function overview(): void
    {
        if (!SessionManager::isLoggedIn()) {
            header('Location: /');
            exit;
        }

        $model = $this->handleReportRequest();

        if (!isset($model))
        {
            include_once(__DIR__ . '/../views/reports/overview.php');
            return;
        }

        $chartTitle = $this->generateChartTitle($model); // Generate title based on model
        $category_names = $this->transactionsService->getCategoryNamesOfTransactions();

        $categoryCosts = [];
        foreach ($model->categoryCosts as $category => $decimalObj) {
            $categoryCosts[$category] = $decimalObj->getValue();  // Access the private value through the getter
        }

        include_once(__DIR__ . '/../views/reports/overview.php');
    }

    public function daily(): void
    {
        if (!SessionManager::isLoggedIn()) {
            header('Location: /');
            exit;
        }

        $model = $this->handleReportRequest(); // Removed the chart title parameter

        if (!isset($model))
        {
            include_once(__DIR__ . '/../views/reports/daily.php');
            return;
        }

        $chartTitle = $this->generateChartTitle($model); // Generate title based on model
        $category_names = $this->transactionsService->getCategoryNamesOfTransactions();

        $costsByDate = [];
        $categoryCostsByDate = []; // To hold category costs by date

        if (isset($model->selectedTransactions)) {
            foreach ($model->selectedTransactions as $transaction) {
                $date = $transaction->date; // Format the date
                $cost = $transaction->cost->getValue(); // Get the cost
                $category = $transaction->category; // Assuming this is available

                // Initialize if not already present
                if (!isset($costsByDate[$date])) {
                    $costsByDate[$date] = 0;
                    $categoryCostsByDate[$date] = [];
                }

                // Aggregate costs by date
                $costsByDate[$date] += $cost;

                // Aggregate costs by category for the date
                if (!isset($categoryCostsByDate[$date][$category])) {
                    $categoryCostsByDate[$date][$category] = 0;
                }
                $categoryCostsByDate[$date][$category] += $cost;
            }
        }

        include_once __DIR__ . '/../views/reports/daily.php';
    }

    private function handleReportRequest(): ?GenerateReportResponse
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->generateResponse(); // Just return the model directly
        } else {
            if (!empty($this->transactionsService->getFirstTransaction()))
            {
                $request = new GenerateReportRequest();
                $request->firstDate = new DateTime($this->transactionsService->getFirstTransaction()->date);
                $request->lastDate = new DateTime('now');
                $request->type = "Expense";

                return $this->reportsService->generateReport($request, false);
            }
            else
            {
                return null;
            }
        }
    }

    private function generateResponse(): GenerateReportResponse
    {
        $withCategory = !(empty($_POST['category']));

        $request = new GenerateReportRequest();

        if (isset($_POST['category']))
            $request->category = $_POST['category'];

        $request->firstDate = date_create_from_format('Y-m-d', $_POST['firstDate']);
        $request->lastDate = date_create_from_format('Y-m-d', $_POST['lastDate']);
        $request->type = $_POST['type'];

        return $this->reportsService->generateReport($request, $withCategory);
    }
}