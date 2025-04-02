<?php

namespace App\Services\Contact;

use App\Repositories\Eloquent\ContactRepository;
use App\Traits\CrudMethodsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactService
{
    use CrudMethodsTrait;

    protected $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }
}
