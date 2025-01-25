<?php

namespace App\Services;

use App\Repositories\Eloquent\SchedulerRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use function Symfony\Component\String\s;

class SchedulerService
{
    protected SchedulerRepository $schedulerRepository;

    public function __construct(SchedulerRepository $schedulerRepository)
    {
        $this->schedulerRepository = $schedulerRepository;
    }

    public function index($type)
    {
        switch ($type) {
            case 'month':
            case 'week':
            case 'day':
            case 'list':
        }
    }

    public function show(int $id): Model
    {
        return $this->schedulerRepository->find($id);
    }

    public function assignEntitiesToScheduler(int $id, string $type, array $entityIds): Model
    {
        return $this->schedulerRepository->assignEntitiesToScheduler($id, $type, $entityIds);
    }

    public function store(array $data): Model
    {
        return $this->schedulerRepository->create($data);
    }

    public function update( int $id, array $data): Model
    {
        return $this->schedulerRepository->update($id, $data);
    }

    public function destroy(int $id): void
    {
        $this->schedulerRepository->delete($id);
    }
}
