<?php

namespace App\Repositories\Eloquent\Kanban;

use App\Models\Kanban\Dashboard;
use App\Repositories\Eloquent\RepositoryBase;

class DashboardRepository extends RepositoryBase
{
    public function __construct(Dashboard $dashboard)
    {
        parent::__construct($dashboard);
    }

    public function updateRelatedTeams($dashboard, $teams): void
    {
        $dashboard->teams()->sync($teams);
    }
}
