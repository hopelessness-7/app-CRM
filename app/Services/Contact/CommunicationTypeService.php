<?php

namespace App\Services\Contact;

use App\Repositories\Eloquent\CommunicationTypeRepository;

class CommunicationTypeService
{
    protected CommunicationTypeRepository $communicationTypeRepository;
    public function __construct(CommunicationTypeRepository $communicationTypeRepository)
    {
        $this->$communicationTypeRepository = $communicationTypeRepository;
    }

    public function getTypes()
    {
        return $this->communicationTypeRepository->all();
    }
}
