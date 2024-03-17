<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\Interfaces\EloquentBase;
use Illuminate\Pagination\LengthAwarePaginator;

class RepositoryBase implements EloquentBase
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function paginate(int $paginate): LengthAwarePaginator
    {
        return $this->model->paginate($paginate);
    }

    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function findMany(array $ids): Model
    {
        return $this->model->findMany($ids);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }
}
