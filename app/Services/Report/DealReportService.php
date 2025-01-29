<?php

namespace App\Services\Report;

use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class DealReportService implements ReportServiceInterface
{
    //Отчеты по сделкам
    //Общий объем сделок: Анализировать все сделки за определенный период (ежедневно, ежемесячно, ежеквартально).
    //Сделки по статусу и этапу: Разделить сделки на группы по статусу.
    //Средняя продолжительность сделки: Сколько времени в среднем занимает закрытие сделки.
    //Объем сделок по сотрудникам: Какие сотрудники закрывают больше всего сделок или какие сделки наиболее прибыльные.
    //Прогнозирование дохода: Используя текущие сделки, предсказать доходы на основе вероятных сделок.
    protected array $reportData = [];

    public function generateReport(array $filters): string
    {
        $reportPatch = '';
        return $reportPatch;
    }

    public function setReportData(array $filters): void
    {
        $query = Deal::query();

        // фильтр по времени
        if (!empty($filters['period'])) {
            $this->applyPeriodFilter($query, $filters);
        }

        if (!empty($filters['status']) && is_array($filters['status'])) {
            $this->validateAndApplyFilter($query, $filters['status'], Deal::$statuses, 'status');
        }

        if (!empty($filters['stage']) && is_array($filters['stage'])) {
            $this->validateAndApplyFilter($query, $filters['stage'], Deal::$stages, 'stage');
        }
        // Среднее время закрытия сделки (по всем сделкам с завершенными статусами)
        if (!empty($filters['completed_deals'])) {
            $this->reportData['completed_deals'] = Deal::whereIn('status', [Deal::STATUS_COMPLETED, Deal::STATUS_CANCELLED])
                ->whereIn('stage', [Deal::STAGE_CLOSED_WON, Deal::STAGE_CLOSED_LOST])
                ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) as avg_closing_time')
                ->value('avg_closing_time');
        }
        // Ожидаемая прибыль по отфильтрованным сделкам (исключая завершенные)
        if (!empty($filters['revenue_forecasting']) && $filters['revenue_forecasting'] === true) {
            $this->reportData['expected_revenue'] = (clone $query)
                ->whereNotIn('status', [Deal::STATUS_COMPLETED, Deal::STATUS_CANCELLED])
                ->whereNotIn('stage', [Deal::STAGE_CLOSED_WON, Deal::STAGE_CLOSED_LOST])
                ->sum('revenue');
        }

        $this->reportData['deals'] = $query->get();
    }

    private function applyPeriodFilter(Builder $query, mixed $options): void
    {
        $startDate = Carbon::now();
        $period = $options['period'];

        switch ($period) {
            case 'today':
                $query->whereDate('created_at', '>=', $startDate->toDateString());
                break;
            case 'week':
                $query->whereBetween('created_at', [$startDate->startOfWeek(), $startDate->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween('created_at', [$startDate->startOfMonth(), $startDate->endOfMonth()]);
                break;
            case 'year':
                $query->whereBetween('created_at', [$startDate->startOfYear(), $startDate->endOfYear()]);
                break;
            case 'custom':
                if (!empty($options['start_date']) && !empty($options['end_date'])) {
                    $query->whereBetween('created_at', [$options['start_date'], $options['end_date']]);
                }
                break;
            default:
                throw new \InvalidArgumentException("Invalid period filter: {$period}");
        }
    }

    private function validateAndApplyFilter(Builder $query, array $values, array $allowedValues, string $fieldName): void
    {
        foreach ($values as $value) {
            if (in_array($value, $allowedValues, true)) {
                throw new \InvalidArgumentException("$fieldName deals '{$value}' is not allowed. Allowed types are: " . implode(', ', $allowedValues));
            }
        }

        $query->whereIn($fieldName, $values);
    }
}
