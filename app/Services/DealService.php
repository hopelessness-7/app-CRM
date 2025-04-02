<?php

namespace App\Services;

use App\Models\Deal;
use App\Repositories\Eloquent\DealRepository;
use App\Traits\CrudMethodsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class DealService
{
    use CrudMethodsTrait;

    protected $repository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->repository = $dealRepository;
    }

    public function confirmDeal($dealId, $data): Model
    {
        $this->repository->confirmDeal($dealId, $data);
        return $this->show($dealId);
        // синхронизация с модулем eCommerce ...
    }

    public function getDealsFromClient($clientId, $paginate): LengthAwarePaginator
    {
        return $this->repository->getDealsFromClient($clientId, $paginate);
    }
}
