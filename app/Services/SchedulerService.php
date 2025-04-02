<?php

namespace App\Services;

use App\Repositories\Eloquent\SchedulerRepository;
use App\Traits\CrudMethodsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use function Symfony\Component\String\s;

class SchedulerService
{
    use CrudMethodsTrait;

    protected $repository;

    public function __construct(SchedulerRepository $schedulerRepository)
    {
        $this->repository = $schedulerRepository;
    }

    public function index($type): void
    {
        switch ($type) {
            case 'month':
            case 'week':
            case 'day':
            case 'list':
        }
    }

    public function assignEntitiesToScheduler(int $id, string $type, array $entityIds): Model
    {
        return $this->repository->assignEntitiesToScheduler($id, $type, $entityIds);
    }
}
