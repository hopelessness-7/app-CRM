<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Services\Contact\ContactService;
use Illuminate\Http\Request;

class ContactController extends MainController
{
    protected ContactService $service;
    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $paginate = $request->input('paginate', 10);
            $resource = ContactResource::collection($this->service->index($paginate))->resolve();
            return $this->sendResponse($resource);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function show($id)
    {
        try {
            $resource = ContactResource::make($this->service->show($id))->resolve();
            return $this->sendResponse($resource);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function create(ContactRequest $request)
    {
        try {
            $contact = $request->validated();
            $resource = ContactResource::make($this->service->create($contact))->resolve();
            return $this->sendResponse($resource);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(ContactUpdateRequest $request, $id)
    {
        try {
            $contact = $request->validated();
            $resource = ContactResource::make($this->service->update((int) $id, $contact))->resolve();
            return $this->sendResponse($resource);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function delete($id)
    {
        try {
            $this->service->delete((int) $id);
            return $this->sendResponse([]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }
}
