<?php

namespace App\Services\Kanban;

use App\Repositories\Eloquent\Kanban\TaskRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{

    protected TaskRepository $taskRepository;
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function get($paginate, $id): LengthAwarePaginator
    {
        return $this->taskRepository->getTasksFromDashboard($paginate, $id);
    }

    public function show($id): Model
    {
        return $this->taskRepository->find($id);
    }
    public function store($data): Model
    {
        return $this->taskRepository->create($data);
    }
    public function update($id, $data): Model
    {
        return $this->taskRepository->update($id, $data);
    }
    public function delete($id): void
    {
        $this->taskRepository->delete($id);
    }
}
