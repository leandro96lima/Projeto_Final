<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
{
    protected function baseRules()
    {
        return [
            'type' => ['required', 'string', 'max:255'],
            'new_type' => 'nullable|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'room' => 'nullable|string|max:255',
            'serial_number' => 'required|string|max:255',
        ];
    }

    public function rules()
    {
        $rules = $this->baseRules();

        // Add unique validation for serial_number
        $rules['serial_number'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('equipments')->where(function ($query) {
                return $query->where('type', $this->type);
            }),
        ];

        // Uncomment if you want to apply EquipmentTypeRule
        // if (!$this->isPrecognitive()) {
        //     $rules['type'][] = new EquipmentTypeRule();
        // }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'type' => in_array($this->type, ['OTHER', 'NEW']) && !empty($this->new_type)
                ? $this->new_type
                : $this->type,
        ]);

        $this->merge([
            'type' => ucwords(strtolower($this->type)),
        ]);
    }
}
