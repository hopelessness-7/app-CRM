<?php

namespace App\Services\Report;

interface ReportServiceInterface
{
    public function generateReport(array $filters): string;
    public function setReportData(array $filters): void;
}
