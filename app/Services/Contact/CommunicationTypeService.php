<?php

namespace App\Services\Contact;

use App\Repositories\Eloquent\CommunicationTypeRepository;
use Illuminate\Database\Eloquent\Collection;

class CommunicationTypeService
{
    protected CommunicationTypeRepository $communicationTypeRepository;
    public function __construct(CommunicationTypeRepository $communicationTypeRepository)
    {
        $this->communicationTypeRepository = $communicationTypeRepository;
    }

    public function getTypes(): Collection
    {
        return $this->communicationTypeRepository->all();
    }
}
