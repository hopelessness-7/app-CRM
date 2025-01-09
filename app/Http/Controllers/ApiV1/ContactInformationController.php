<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\MainController;
use App\Services\Contact\CommunicationTypeService;
use App\Services\Contact\ContactInformationService;

class ContactInformationController extends MainController
{
    public function getCommunicationType(CommunicationTypeService $service)
    {
        return $this->executeRequest(function () use ($service) {
            return $service->getTypes();
        });
    }

    public function set(ContactInformationRequest $request, ContactInformationService $service, $contactId)
    {
        return $this->executeRequest(function () use ($request, $service, $contactId) {
            $data = $request->validated();
            return $service->setInformation($data, $contactId);
        });
    }

    public function update(ContactInformationService $service)
    {
        return $this->executeRequest(function () use ($service) {
            return $service->updateInformation();
        });
    }

    public function delete(ContactInformationService $service)
    {
        return $this->executeRequest(function () use ($service) {
            return $service->deleteInformation();
        });
    }
}
