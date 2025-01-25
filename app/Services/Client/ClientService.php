<?php

namespace App\Services\Client;

use App\Repositories\Eloquent\ClientRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService
{
    protected ClientRepository $clientRepository;
    public function __construct(clientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function get(int $paginate = 10): LengthAwarePaginator
    {
        return $this->clientRepository->paginate($paginate);
    }

    public function show(int $clientId): Model
    {
        return $this->clientRepository->find($clientId);
    }

    public function create($data): Model
    {
        return $this->clientRepository->create($data);
    }

    public function update($data, $clientId): Model
    {
        return $this->clientRepository->update($data, $clientId);
    }

    public function delete($clientId): void
    {
        $this->clientRepository->delete($clientId);
    }
}
