<?php

namespace App\Services\Contact;

use App\Models\ContactInformation;
use App\Repositories\Eloquent\ContactInformationRepository;
use Illuminate\Database\Eloquent\Collection;

class ContactInformationService
{
    protected ContactInformationRepository $contactInformationRepository;
    public function __construct(CommunicationTypeRepository $contactInformationRepository)
    {
        $this->$contactInformationRepository = $contactInformationRepository;
    }

    public function getInformation($contactId): Collection
    {
        return $this->contactInformationRepository->where('contact_id', $contactId)->get();
    }
    public function setInformation($data, $contactId)
    {

    }
    public function updateInformation()
    {

    }
    public function deleteInformation()
    {

    }
}
