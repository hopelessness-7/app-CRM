<?php

namespace App\Services;

use App\Models\Deal;
use App\Repositories\Eloquent\DealRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class DealService
{
    protected DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function confirmDeal($dealId, $data): Model
    {
        $this->dealRepository->confirmDeal($dealId, $data);
        return $this->show($dealId);
        // синхронизация с модулем eCommerce ...
    }

    public function getDealsFromClient($clientId, $paginate): LengthAwarePaginator
    {
        return $this->dealRepository->getDealsFromClient($clientId, $paginate);
    }

    public function getAll($paginate): LengthAwarePaginator
    {
        return $this->dealRepository->paginate($paginate);
    }

    public function store($data): Model
    {
        return $this->dealRepository->create($data);
    }

    public function show($id): Model
    {
        return $this->dealRepository->find($id);
    }
    public function update($id, $data): Model
    {
        if (array_key_exists('status', $data) && $data['status'] == Deal::STATUS_CONFIRMED) {
            return $this->confirmDeal($id, $data);
        }

        return $this->dealRepository->update($id, $data);
    }
    public function delete($id): void
    {
        $this->dealRepository->delete($id);
    }
}
