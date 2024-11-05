<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use App\Rules\CheckDuplicateTicket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;


class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required','string','max:255',
                new CheckDuplicateTicket($this->title, $this->description, $this->serial_number),
            ],
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|regex:/^[A-Z]{3}-\d{5}$/i|max:255',
            'description' => 'required|string',
        ];
    }
}
