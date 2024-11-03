<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Pode ser ajustado para verificar permissões
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->isDuplicateTicket()) {
                Log::info('Tentativa de criar um ticket duplicado', [
                    'title' => $this->title,
                    'description' => $this->description,
                    'serial_number' => $this->serial_number,
                ]);

                $validator->errors()->add('ticket', 'Já existe um ticket aberto com os mesmos dados.');
            }
        });
    }

    protected function isDuplicateTicket()
    {
        $isDuplicate = Ticket::where('title', $this->title)
            ->where('description', $this->description)
            ->where('status', 'open')
            ->whereHas('malfunction.equipment', function($query) {
                $query->where('serial_number', $this->serial_number);
            })
            ->exists();

        if ($isDuplicate) {
            Log::info('Um ticket duplicado foi encontrado', [
                'title' => $this->title,
                'description' => $this->description,
                'serial_number' => $this->serial_number,
            ]);
        }

        return $isDuplicate;
    }
}
