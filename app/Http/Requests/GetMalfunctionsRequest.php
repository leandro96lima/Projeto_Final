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
            'status' => 'string',
            'sort' => 'nullable|string',
            'direction' => 'nullable|string'
        ];
    }

    public function validateResolved()
    {
        parent::validateResolved();

        // Obter o status do input
        $status = $this->input('status');

        // Aplicar a regra ao index de malfunctions
        (new TicketStatusNotPendingApproval($this->input('search'), $status))->passes('malfunction_index', null);
    }
}
