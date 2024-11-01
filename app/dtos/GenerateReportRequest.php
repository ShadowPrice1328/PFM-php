<?php

namespace dtos;

require_once(__DIR__ . '/../entities/Report.php');

use DateTime;
use entities\Report;

class GenerateReportRequest
{
    public ?string $category = null;
    public DateTime $firstDate;
    public DateTime $lastDate;
    public string $type;

    public function toReport() : Report
    {
        $report = new Report();

        $report->category = $this->category;
        $report->firstDate = $this->firstDate;
        $report->lastDate = $this->lastDate;
        $report->type = $this->type;

        return $report;
    }
}