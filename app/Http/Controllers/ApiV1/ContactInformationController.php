<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\ContactInformationRequest;
use App\Http\Requests\ContactInformationUpdateRequest;
use App\Services\Contact\CommunicationTypeService;
use App\Services\Contact\ContactInformationService;
use Illuminate\Http\JsonResponse;

class ContactInformationController extends MainController
{
    public function getCommunicationType(CommunicationTypeService $service): JsonResponse
    {
        return $this->executeRequest(function () use ($service) {
            return $service->getTypes();
        });
    }

    public function set(ContactInformationRequest $request, ContactInformationService $service): JsonResponse
    {
        return $this->executeRequest(function () use ($request, $service) {
            $data = $request->validated();
            return $service->setInformation($data);
        });
    }

    public function update(ContactInformationUpdateRequest $request, ContactInformationService $service, $contactInformationId): JsonResponse
    {
        return $this->executeRequest(function () use ($request, $service, $contactInformationId) {
            $data = $request->validated();
            $service->updateInformation($contactInformationId, $data);
        });
    }

    public function delete(ContactInformationService $service, $contactInformationId): JsonResponse
    {
        return $this->executeRequest(function () use ($service, $contactInformationId) {
            $service->deleteInformation($contactInformationId);
        });
    }
}
