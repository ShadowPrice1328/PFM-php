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

        //TO DO: filter by type

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
                $cost = $transaction->cost;

                if (!isset($categoryCosts[$category])) {
                    $categoryCosts[$category] = new Decimal('0.00');
                }
                $categoryCosts[$category] = $categoryCosts[$category]->add(new Decimal((string)$cost));
            }
        }

        return ReportExtensions::toGenerateResponse($report, $selectedTransactions, $categoryCosts);
    }
}