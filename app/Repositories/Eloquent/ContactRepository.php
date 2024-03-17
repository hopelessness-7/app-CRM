<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\RepositoryBase;
use App\Models\Contact;

class ContactRepository extends RepositoryBase
{
    public function __construct(Contact $contactModel)
    {
        parent::__construct($contactModel);
    }
}
