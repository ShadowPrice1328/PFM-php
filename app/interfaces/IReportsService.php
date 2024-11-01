<?php

namespace interfaces;

use dtos\GenerateReportRequest;
use dtos\GenerateReportResponse;

interface IReportsService
{
    public function generateReport(?GenerateReportRequest $model, bool $withCategory) : GenerateReportResponse;
}