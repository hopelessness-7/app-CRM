<?php

namespace App\Repositories\Eloquent;

use App\Models\ContactInformation;

class ContactInformationRepository extends RepositoryBase
{
    public function __construct(ContactInformation $contactInformation)
    {
        parent::__construct($contactInformation);
    }
}
