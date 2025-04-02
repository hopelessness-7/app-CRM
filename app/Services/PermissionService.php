<?php

namespace App\Services;

use App\Repositories\Eloquent\PermissionRepository;
use App\Traits\CrudMethodsTrait;

class PermissionService
{
    use CrudMethodsTrait;

    protected $repository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repository = $permissionRepository;
    }
}
