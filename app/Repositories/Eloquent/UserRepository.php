<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Eloquent\RepositoryBase;

class UserRepository extends RepositoryBase
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
