<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\RepositoryBase;
use App\Models\Role;

class RoleRepository extends RepositoryBase
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }
}
