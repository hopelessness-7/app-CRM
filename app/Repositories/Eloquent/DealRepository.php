<?php

namespace App\Repositories\Eloquent;

use App\Models\Deal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class DealRepository extends RepositoryBase
{
    public function __construct(Deal $deal)
    {
        parent::__construct($deal);
    }

    public function getDealsFromClient($clientId, $paginate): LengthAwarePaginator
    {
        return $this->model->where('client_id', $clientId)->paginate($paginate);
    }

    public function getDealsFromWorker($workerId, $paginate): LengthAwarePaginator
    {
        return $this->model->whereHas('client', function ($query) use ($workerId) {
            $query->where('worker_id', $workerId);
        })->paginate($paginate);
    }

    public function confirmDeal($dealId, $data): void
    {
        $data['stage'] = Deal::STAGE_CLOSED_WON;
        $this->update($dealId, $data);
    }
}
