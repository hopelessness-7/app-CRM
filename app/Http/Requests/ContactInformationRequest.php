<?php

namespace App\Http\Requests;

use App\Models\CommunicationType;
use Illuminate\Validation\Rule;

class ContactInformationRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'contact_id' => ['required', 'integer', 'exists:contacts,id'],
            'communication_type_id' => ['required', 'integer', 'exists:communication_types,id'],
            'value' => ['required', 'string', Rule::in(CommunicationType::$getTypes)],
        ];
    }
}
