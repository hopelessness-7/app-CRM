<?php

namespace App\Services\Contact;

use App\Repositories\Eloquent\ContactInformationRepository;
use App\Repositories\Eloquent\ContactRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ContactInformationService
{
    protected ContactInformationRepository $contactInformationRepository;
    protected ContactRepository $contactRepository;
    public function __construct(ContactInformationRepository $contactInformationRepository, ContactRepository $contactRepository)
    {
        $this->contactInformationRepository = $contactInformationRepository;
        $this->contactRepository = $contactRepository;
    }

    public function getInformation($contactId): Collection
    {
        return $this->contactInformationRepository->where('contact_id', $contactId)->get();
    }
    public function setInformation($data): Model
    {
        return $this->contactInformationRepository->create($data);
    }
    public function updateInformation($contactInformationId, $data): void
    {
        $this->contactInformationRepository->update($contactInformationId, $data);
    }
    public function deleteInformation($contactInformationId): void
    {
        $this->contactInformationRepository->delete($contactInformationId);
    }
}
