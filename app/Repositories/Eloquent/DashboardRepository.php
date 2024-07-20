<?php

namespace App\Repositories\Eloquent;

use App\Models\Kanban\Dashboard;
use App\Repositories\Eloquent\RepositoryBase;

class DashboardRepository extends RepositoryBase
{
    public function __construct(Dashboard $dashboard)
    {
        parent::__construct($dashboard);
    }
}
