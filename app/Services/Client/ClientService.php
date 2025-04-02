<?php

namespace App\Services\Client;

use App\Repositories\Eloquent\ClientRepository;
use App\Traits\CrudMethodsTrait;

class ClientService
{
    use CrudMethodsTrait;

    protected $repository;
    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }
}
