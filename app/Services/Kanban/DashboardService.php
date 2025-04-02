<?php

namespace App\Services\Kanban;

use App\Repositories\Eloquent\Kanban\DashboardRepository;
use App\Traits\CrudMethodsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardService
{
    use CrudMethodsTrait;

    protected $repository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->repository = $dashboardRepository;
    }
}
