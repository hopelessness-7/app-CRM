<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\Interfaces\EloquentBase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class RepositoryBase implements EloquentBase
{
    protected Model $model;
    protected Builder $query;

    protected function modelException ($model): Model
    {
        if (!$model) {
            throw new \Exception('item not found', 404);
        }

        return $model;
    }

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = $model->newQuery();
    }

    public function paginate(int $paginate): LengthAwarePaginator
    {
        return $this->model->paginate($paginate);
    }

    public function find(int $id): Model
    {
        $model = $this->model->find($id);
        return $this->modelException($model);
    }

    public function findMany(array $ids): Collection
    {
        return $this->model->findMany($ids);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
        $model = $this->model->find($id);
        $checkModel = $this->modelException($model);
        return $checkModel->update($data);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * Apply a basic where clause.
     */
    public function where(string $field, mixed $operatorOrValue, mixed $value = null): static
    {
        if (is_null($value)) {
            $this->query->where($field, '=', $operatorOrValue);
        } else {
            $this->query->where($field, $operatorOrValue, $value);
        }
        return $this;
    }

    /**
     * Apply a whereIn clause.
     */
    public function whereIn(string $field, array $values): static
    {
        $this->query->whereIn($field, $values);
        return $this;
    }

    /**
     * Execute the query and return a collection.
     */
    public function get(): Collection
    {
        return $this->query->get();
    }

    public function paginateQuery(int $paginate): LengthAwarePaginator
    {
        return $this->query->paginate($paginate);
    }

    public function findQuery($id): Model
    {
        return $this->query->find($id);
    }

    public function firstQuery(): Model
    {
        return $this->query->first();
    }

    /**
     * Apply a select clause.
     */
    public function select(array $columns): static
    {
        $this->query->select($columns);
        return $this;
    }

    /**
     * Reset query for a new request (optional utility method).
     */
    public function resetQuery(): static
    {
        $this->query = $this->model->newQuery();
        return $this;
    }
}
