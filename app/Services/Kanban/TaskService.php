<?php

namespace App\Services\Kanban;

use App\Repositories\Eloquent\Kanban\TaskRepository;
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

    public function show($id): \Illuminate\Database\Eloquent\Model
    {
        return $this->taskRepository->find($id);
    }
    public function store($data): \Illuminate\Database\Eloquent\Model
    {
        return $this->taskRepository->create($data);
    }
    public function update($id, $data): \Illuminate\Database\Eloquent\Model
    {
        $this->taskRepository->update($id, $data);
        return $this->show($id);
    }
    public function delete($id): void
    {
        $this->taskRepository->delete($id);
    }
}
