<?php

namespace controllers;

require_once __DIR__ . "/../viewmodels/TransactionViewModel.php";
require_once __DIR__ . "/../dtos/TransactionUpdateRequest.php";
require_once __DIR__ . "/../dtos/TransactionAddRequest.php";
require_once __DIR__ . "/../enums/TransactionTypeOptions.php";


use DatabaseService;
use dtos\TransactionAddRequest;
use dtos\TransactionUpdateRequest;
use enums\TransactionTypeOptions;
use interfaces\ICategoriesService;
use models\Decimal;
use services\TransactionsService;
use viewmodels\TransactionViewModel;

class TransactionsController
{
    private DatabaseService $databaseService;
    private TransactionsService $transactionService;
    private ICategoriesService $categoriesService;

    public function __construct($databaseService, $transactionService, $categoriesService)
    {
        $this->databaseService = $databaseService;
        $this->transactionService = $transactionService;
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

    public function index() : void
    {
        $model = new TransactionViewModel(
            $this->transactionService->getTransactions(),
            $this->transactionService->getCategoryNamesOfTransactions()
        );

        include_once(__DIR__ . '/../views/transactions/index.php');
    }

    public function filter(string $filterBy, ?string $filterString)
    {
        $filtered_transactions = $this->transactionService->getFilteredTransactions($filterBy, $filterString);
        // Include the layout but focus on the content part
        ob_start();
        include_once(__DIR__ . '/../partialViews/transactions_partial.php'); // Assuming this includes the categories table
        $content = ob_get_clean();

        // Return the content as JSON
        header('Content-Type: application/json');
        echo json_encode(['content' => $content]);
        exit;
    }

    public function edit(string $id) : void
    {
        $transaction = $this->transactionService->getTransactionByTransactionId($id);
        $category_names = $this->categoriesService->getCategoryNames();

        $errors = [];

        if (!$transaction)
        {
            include_once __DIR__ . '/../views/404.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $category = trim($_POST['category']);
            $type = trim($_POST['type']);
            $cost = trim($_POST['cost']);
            $date = trim($_POST['date']);
            $description = trim($_POST['description']);
            $id = $_POST['id'];

            $transactionUpdateRequest = new TransactionUpdateRequest($id, $category, TransactionTypeOptions::from($type), new Decimal($cost), $date, $description);

            $errors = $transactionUpdateRequest->validate();

            if (empty($errors)) {
                // Update the category if no validation errors
                $updated = $this->transactionService->updateTransaction($transactionUpdateRequest);

                if ($updated) {
                    // Redirect to categories list on success
                    header("Location: /transactions");
                    exit;
                } else {
                    $errors['summary'] = 'An error occurred while updating the category.';
                }
            }
        }

        include_once(__DIR__ . '/../views/transactions/edit.php');
    }

    public function details(string $id) : void
    {
        $transaction = $this->transactionService->getTransactionByTransactionId($id);

        if (!$transaction)
        {
            include_once __DIR__ . '/../views/404.php';
            return;
        }

        include_once(__DIR__ . '/../views/transactions/details.php');
    }

    public function delete(string $id) : void
    {
        $transaction = $this->transactionService->getTransactionByTransactionId($id);

        if (!$transaction)
        {
            include_once __DIR__ . '/../views/404.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $deleted = $this->transactionService->deleteTransaction($id);

            if ($deleted)
            {
                header("Location: /transactions");
                exit;
            }
        }

        include_once(__DIR__ . '/../views/transactions/delete.php');
    }

    public function create() : void
    {
        $category_names = $this->transactionService->getCategoryNamesOfTransactions();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $category = trim($_POST['category']);
            $type = TransactionTypeOptions::from(trim($_POST['type']));
            $cost = new Decimal(trim($_POST['cost']));
            $date = trim($_POST['date']);
            $description = trim($_POST['description']);

            $request = new TransactionAddRequest($category, $type, $cost, $date, $description);
            $errors = $request->validate();

            if (empty($errors))
            {
                $this->transactionService->addTransaction($request);
                header("Location: /transactions");
                exit;
            }
        }

        include_once __DIR__ . '/../views/transactions/create.php';
    }
}