<?php

namespace App\Services;

use App\Repositories\Eloquent\WorkerRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkerService
{
    protected WorkerRepository $repository;

    public function __construct(WorkerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(int $paginate): LengthAwarePaginator
    {
        return $this->repository->paginate($paginate);
    }

    public function show(int $id): Model
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id): int
    {
        return $this->repository->delete($id);
    }
}
