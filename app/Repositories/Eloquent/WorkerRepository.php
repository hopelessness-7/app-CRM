<?php

namespace App\Repositories\Eloquent;

use App\Models\Worker;

class WorkerRepository extends RepositoryBase
{
    public function __construct(Worker $worker)
    {
        parent::__construct($worker);
    }
}
