<?php

namespace App\Http\Requests;

use App\Models\CommunicationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactInformationUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'contact_id' => ['integer', 'exists:contacts,id'],
            'communication_type_id' => ['integer', 'exists:communication_types,id'],
            'value' => ['string', Rule::in(CommunicationType::$getTypes)],
        ];
    }
}
