<?php

namespace App\Services\Chat;

use App\Repositories\Eloquent\Chat\RoomRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomService
{
    protected RoomRepository $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function get($paginate): LengthAwarePaginator
    {
        return $this->roomRepository->paginate($paginate);
    }

    public function create($data): Model
    {
        return $this->roomRepository->create($data);
    }

    public function show($roomId): Model
    {
        return $this->roomRepository->find($roomId);
    }

    /**
     * @throws \Exception
     */
    public function update($roomId, $data): Model
    {
        return $this->roomRepository->update($roomId, $data);
    }

    public function delete($roomId): void
    {
        $this->roomRepository->delete($roomId);
    }
}
