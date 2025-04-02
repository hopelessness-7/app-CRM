<?php

namespace App\Services\Kanban;

use App\Repositories\Eloquent\Kanban\TaskRepository;
use App\Traits\CrudMethodsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    use CrudMethodsTrait;

    protected $repository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->repository = $taskRepository;
    }

}
