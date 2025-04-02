<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\RepositoryBase;
use App\Models\Permission;

class PermissionRepository extends RepositoryBase
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }
}
