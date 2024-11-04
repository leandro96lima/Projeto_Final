<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\TicketStatusNotPendingApproval;

class GetMalfunctionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'search' => 'nullable|string',
        ];
    }

    public function validateResolved()
    {
        parent::validateResolved();

        // Aplicar a regra ao index de malfunctions
        (new TicketStatusNotPendingApproval($this->input('search')))->passes('malfunction_index', null);
    }
}
