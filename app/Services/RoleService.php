<?php

namespace App\Services;

use App\Repositories\Eloquent\RoleRepository;
use App\Traits\CrudMethodsTrait;

class RoleService
{
    use CrudMethodsTrait;

    protected $repository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->repository = $roleRepository;
    }
}
