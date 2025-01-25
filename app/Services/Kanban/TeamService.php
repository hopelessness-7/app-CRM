<?php

namespace App\Services\Kanban;

use App\Repositories\Eloquent\Kanban\TeamRepository;

class TeamService
{
    protected TeamRepository $teamRepository;
    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index($paginate): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->teamRepository->paginate($paginate);
    }

    public function show($id): \Illuminate\Database\Eloquent\Model
    {
        return $this->teamRepository->find($id);
    }

    public function store($data)
    {
        return $this->teamRepository->create($data);
    }

    public function update($id, $data): void
    {
        $this->teamRepository->update($id, $data);
    }

    public function delete($id): void
    {
        $this->teamRepository->delete($id);
    }
}
