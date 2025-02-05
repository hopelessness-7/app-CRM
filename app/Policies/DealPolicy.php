<?php

namespace App\Policies;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('list-deals');
    }

    public function view(User $user, Deal $deal): bool
    {
        return $user->hasPermission('view-deals');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create-deals');
    }

    public function update(User $user, Deal $deal): bool
    {
        return $user->hasPermission('update-deals');
    }

    public function delete(User $user, Deal $deal): bool
    {
        return $user->hasPermission('delete-deals');
    }
}
