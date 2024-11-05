<?php

namespace App\Http\Requests;

use App\Rules\PreventRevertToOpen;
use Illuminate\Foundation\Http\FormRequest;

class StoreMalfunctionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $malfunction = $this->route('malfunction'); // Get the malfunction instance from the route

        return [
            'status' => [
                'required',
                'string',
                'max:255',
                new PreventRevertToOpen($malfunction), // Apply the custom rule
            ],
            'cost' => 'nullable|numeric|min:0',
            'solution' => 'nullable|string',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'urgent' => 'required|boolean',
        ];
    }
}
