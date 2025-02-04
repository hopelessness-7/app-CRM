<?php

namespace App\Services\Kanban;

use App\Repositories\Eloquent\Kanban\DashboardRepository;
use Illuminate\Database\Eloquent\Model;

class DashboardService
{
    protected DashboardRepository $dashboardRepository;
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getDashboard($paginate): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->dashboardRepository->paginate($paginate);
    }

    public function show($id): \Illuminate\Database\Eloquent\Model
    {
        return $this->dashboardRepository->find($id);
    }

    public function store($data)
    {
        return $this->dashboardRepository->create($data);
    }

    public function update($id, $data): Model
    {
        return $this->dashboardRepository->update($id, $data);
    }

    public function delete($id): void
    {
        $this->dashboardRepository->delete($id);
    }
}
