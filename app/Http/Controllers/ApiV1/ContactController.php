<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\ContactRequest;
use App\Services\ContactService;

class ContactController extends MainController
{
    protected ContactService $service;
    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    public function index()
    {

    }

    public function show($id)
    {
        try {
            return $this->sendResponse($this->service->show($id), 200);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function create(ContactRequest $request)
    {
        try {
            $contact = $request->validated();
            return $this->sendResponse($this->service->create($contact));
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(ContactRequest $request, $id)
    {
        try {
            $contact = $request->validated();
            return $this->sendResponse($this->service->update((int) $id, $contact));
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
