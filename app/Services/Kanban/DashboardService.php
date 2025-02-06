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
        $dashboard =  $this->dashboardRepository->create($data);

        if (array_key_exists('teams', $data) && !empty($data['teams'])) {
            $this->dashboardRepository->updateRelatedTeams($dashboard, $data['teams']);
        }

        return $dashboard;
    }

    public function update($id, $data): Model
    {
        $dashboard = $this->dashboardRepository->update($id, $data);

        if (array_key_exists('teams', $data) && !empty($data['teams'])) {
            $this->dashboardRepository->updateRelatedTeams($dashboard, $data['teams']);
        }
        return $dashboard;
    }

    public function delete($id): void
    {
        $this->dashboardRepository->delete($id);
    }
}
