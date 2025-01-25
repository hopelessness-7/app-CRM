<?php

namespace App\Repositories\Eloquent\Kanban;

use App\Models\Kanban\Team;
use App\Repositories\Eloquent\RepositoryBase;

class TeamRepository extends RepositoryBase
{
    public function __construct(Team $team)
    {
        parent::__construct($team);
    }
}
