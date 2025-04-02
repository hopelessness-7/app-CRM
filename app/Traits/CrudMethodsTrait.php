<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait CrudMethodsTrait
{
    /**
     * @var object Репозиторий, который будет использоваться для CRUD-операций.
     */
    protected $repository;

    /**
     * Получение пагинированного списка записей.
     *
     * @param int $paginate Количество элементов на странице
     * @return LengthAwarePaginator
     */
    public function index(int $paginate): LengthAwarePaginator
    {
        return $this->repository->paginate($paginate);
    }

    /**
     * Получение записи по ID.
     *
     * @param int $id ID записи
     * @return Model
     */
    public function show(int $id): Model
    {
        return $this->repository->find($id);
    }

    /**
     * Создание новой записи.
     *
     * @param array $data Данные для создания записи
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Обновление существующей записи.
     *
     * @param int $id ID записи
     * @param array $data Данные для обновления
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Удаление записи по ID.
     *
     * @param int $id ID записи
     * @return int Количество удаленных записей
     */
    public function delete(int $id): int
    {
        return $this->repository->delete($id);
    }
}
