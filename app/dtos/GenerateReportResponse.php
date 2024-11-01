<?php

namespace dtos;

use DateTime;
use entities\Report;
use models\Decimal;

class GenerateReportResponse
{
    public ?string $category; // Nullable string
    public DateTime $firstDate; // DateTime object
    public DateTime $lastDate; // DateTime object
    public string $type; // Non-nullable string
    public array $selectedTransactions; // List of TransactionResponse
    public array $categoryCosts; // Dictionary of string to decimal
    public Decimal $categoryTotalCost; // Total cost

    public function __construct(
        ?string $category,
        DateTime $firstDate,
        DateTime $lastDate,
        string $type,
        array $selectedTransactions,
        array $categoryCosts,
        Decimal $categoryTotalCost
    ){
        $this->category = $category;
        $this->firstDate = $firstDate;
        $this->lastDate = $lastDate;
        $this->type = $type;
        $this->selectedTransactions = $selectedTransactions;
        $this->categoryCosts = $categoryCosts;
        $this->categoryTotalCost = $categoryTotalCost;
    }
}

class ReportExtensions
{

    public static function toGenerateResponse(Report $report, array $transactions, array $categoryCost) : GenerateReportResponse
    {
        $totalCost = new Decimal('0.00'); // Initialize total cost as Decimal

        foreach ($transactions as $transaction) {
            // Assuming $transaction->cost is a string or a valid decimal format
            $totalCost = $totalCost->add(new Decimal((string)$transaction->cost));
        }

        return new GenerateReportResponse(
            $report->category,
            $report->firstDate,
            $report->lastDate,
            $report->type,
            $transactions,
            $categoryCost,
            $totalCost
        );
    }
}