<?php

namespace App\Repositories\Search\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseSearch
{
    public function search(Model $model, string $query = '', string $field = 'title', $exact = false, $perPage = null): mixed;
}
