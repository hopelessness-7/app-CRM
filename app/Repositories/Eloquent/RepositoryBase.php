<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\Interfaces\EloquentBase;
use Illuminate\Pagination\LengthAwarePaginator;

class RepositoryBase implements EloquentBase
{
    protected $model;

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
}
