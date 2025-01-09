<?php

namespace App\Repositories\Eloquent;

use App\Models\CommunicationType;

class CommunicationTypeRepository extends RepositoryBase
{
    public function __construct(CommunicationType $communicationType)
    {
        parent::__construct($communicationType);
    }
}
