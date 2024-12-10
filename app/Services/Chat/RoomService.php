<?php

namespace App\Services\Chat;

use App\Repositories\Eloquent\Chat\RoomRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomService
{
    protected RoomRepository $repository;

    public function __construct(RoomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get($paginate): LengthAwarePaginator
    {
        return $this->repository->paginate($paginate);
    }

    public function send($data): Model
    {
        return $this->repository->create($data);
    }

    public function show($roomId): Model
    {
        return $this->repository->find($roomId);
    }

    /**
     * @throws \Exception
     */
    public function update($roomId, $data): Model
    {
        $this->repository->update($roomId, $data);
        return $this->show($roomId);
    }

    public function delete($roomId): void
    {
        $this->repository->delete($roomId);
    }
}
