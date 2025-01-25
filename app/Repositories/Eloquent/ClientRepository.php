<?php

namespace App\Repositories\Eloquent;

use App\Models\Client;
use App\Repositories\Eloquent\RepositoryBase;
use Illuminate\Database\Eloquent\Model;

class ClientRepository extends RepositoryBase
{
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }
}
