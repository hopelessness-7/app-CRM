<?php

namespace App\Services\Kanban;

use App\Repositories\Eloquent\Kanban\TaskRepository;
use Illuminate\Database\Eloquent\Model;

class ClientTaskService
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function setClientFromTask($data): Model
    {
        return $this->taskRepository->setClientFromTask($data);
    }

    public function deleteClientFromTask($data):Model
    {
        return $this->taskRepository->deleteClientFromTask($data);
    }
}
