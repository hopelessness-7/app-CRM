<?php

namespace App\Services\Kanban;

use App\Repositories\Eloquent\Kanban\TeamRepository;
use App\Traits\CrudMethodsTrait;

class TeamService
{
    use CrudMethodsTrait;

    protected $repository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->repository = $teamRepository;
    }
}
