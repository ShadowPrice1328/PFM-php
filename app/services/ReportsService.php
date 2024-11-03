<?php

namespace services;

require_once(__DIR__ . '/../interfaces/IReportsService.php');
require_once(__DIR__ . '/../dtos/GenerateReportResponse.php');


use dtos\GenerateReportRequest;
use dtos\GenerateReportResponse;
use dtos\ReportExtensions;
use interfaces\IReportsService;
use interfaces\ITransactionsService;
use InvalidArgumentException;
use models\Decimal;

class ReportsService implements IReportsService
{
    private readonly ITransactionsService $transactionsService;

    public function __construct(ITransactionsService $transactionsService)
    {
        $this->transactionsService = $transactionsService;
    }

    public function generateReport(?GenerateReportRequest $model, bool $withCategory): GenerateReportResponse
    {
        if (empty($model))
        {
            throw new InvalidArgumentException("GenerateReportRequest model cannot be null");
        }

        $report = $model->toReport();

        $selectedTransactions = $this->transactionsService->getTransactionBetweenTwoDates($report->firstDate, $report->lastDate);

        $selectedTransactions = array_filter($selectedTransactions, function ($transaction) use ($model) {
            return $transaction->type === $model->type;
        });

        if ($withCategory)
        {
            $selectedTransactions = array_filter($selectedTransactions, function ($transaction) use ($model) {
                return $transaction->category === $model->category;
            });
        }

        // Calculate category costs by grouping transactions by category
        $categoryCosts = [];
        foreach ($selectedTransactions as $transaction) {
            if ($transaction->category) {
                $category = $transaction->category;

                // Convert cost to a numeric value
                $costValue = $transaction->cost instanceof Decimal ? (string)$transaction->cost->getValue() : (string)$transaction->cost;

                // Initialize category cost if it doesn't exist
                if (!isset($categoryCosts[$category])) {
                    $categoryCosts[$category] = new Decimal('0.00');
                }
                // Add the cost to the category total
                $categoryCosts[$category] = $categoryCosts[$category]->add(new Decimal($costValue));

                // Also add the transaction to the response with the cost as a numeric value
                $transaction->cost = new Decimal($costValue); // Update transaction's cost to a numeric value
            }
        }

        return ReportExtensions::toGenerateResponse($report, $selectedTransactions, $categoryCosts);
    }
}