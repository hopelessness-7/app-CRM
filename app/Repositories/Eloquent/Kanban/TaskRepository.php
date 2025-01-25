<?php

namespace App\Repositories\Eloquent\Kanban;

use App\Models\Kanban\Task;
use App\Repositories\Eloquent\RepositoryBase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository extends RepositoryBase
{
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    public function setClientFromTask(array $data): Model
    {
        $task = $this->find($data['task_id']);
        $task->clients->attach($data['client_id']);
        return $task;
    }
    public function deleteClientFromTask($data): Model
    {
        $task = $this->find($data['task_id']);
        $task->clients->detach($data['client_id']);
        return $task;
    }

    public function getTasksFromDashboard($paginate, $id): LengthAwarePaginator
    {
        return $this->model->where('dashboard_id', $id)->paginate($paginate);
    }
}
