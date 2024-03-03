<?php

namespace App\Repositories\Search;

use App\Repositories\Search\Interfaces\BaseSearch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentRepository implements Interfaces\BaseSearch
{

    public function search(Model $model, string $query = '', string $field = 'title', $exact = false, $perPage = null): Collection
    {
        if ($exact) {
            $request = $model::where($field, $query);
        } else {
            $request = $model::where($field, 'like', "%{$query}%");
        }

        if (is_null($perPage)) {
            return $request->get();
        } else {
            return $request->paginate($perPage);
        }
    }
}
