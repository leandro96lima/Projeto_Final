<?php

namespace App\Rules;

use App\Models\Ticket;
use Illuminate\Contracts\Validation\Rule;

class CheckDuplicateTicket implements Rule
{
    protected $title;
    protected $description;
    protected $serialNumber;

    public function __construct($title, $description, $serialNumber)
    {
        $this->title = $title;
        $this->description = $description;
        $this->serialNumber = $serialNumber;
    }

    public function passes($attribute, $value)
    {
        return !Ticket::where('title', $this->title)
            ->where('description', $this->description)
            ->where('status', 'open')
            ->whereHas('malfunction.equipment', function ($query) {
                $query->where('serial_number', $this->serialNumber);
            })
            ->exists();
    }

    public function message()
    {
        return 'Já existe um ticket aberto com os mesmos dados.';
    }
}
