<?php

namespace App\Services\Contact;

use App\Repositories\Eloquent\ContactRepository;
use Illuminate\Database\Eloquent\Model;

class ContactService
{
    protected ContactRepository $contactRepository;
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index($paginate)
    {
        return $this->contactRepository->paginate($paginate);
    }
    public function show(int $id): Model
    {
        return $this->contactRepository->find($id);
    }

    public function create(array $contact): Model
    {
        return $this->contactRepository->create($contact);
    }

    public function update(int $id, array $contact): Model
    {
        return $this->contactRepository->update($id, $contact);
    }

    public function delete($id): int
    {
        return $this->contactRepository->delete($id);
    }
}
