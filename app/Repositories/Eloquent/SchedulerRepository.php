<?php

namespace App\Repositories\Eloquent;

use App\Models\Scheduler;
use Illuminate\Database\Eloquent\Model;

class SchedulerRepository extends RepositoryBase
{
    public function __construct(Scheduler $scheduler)
    {
        parent::__construct($scheduler);
    }

    public function assignEntitiesToScheduler(int $id, string $type, array $entityIds): Model
    {
        $allowedTypes = ['deals', 'clients', 'workers'];

        if (!in_array($type, $allowedTypes)) {
            throw new \InvalidArgumentException("Type '{$type}' is not allowed. Allowed types are: " . implode(', ', $allowedTypes));
        }

        $scheduler = $this->find($id);

        if (!method_exists($scheduler->$type(), 'attach')) {
            throw new \RuntimeException("Unable to associate entities. Ensure the '{$type}' relationship is defined and supports 'attach'.");
        }

        try {
            $scheduler->$type()->attach($entityIds); // Ensure it's a relation method, not property

            return $scheduler;
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to assign entities to scheduler: {$e->getMessage()}");
        }
    }
}
