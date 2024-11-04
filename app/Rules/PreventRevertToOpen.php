<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PreventRevertToOpen implements Rule
{
    protected $malfunction;

    public function __construct($malfunction)
    {
        $this->malfunction = $malfunction;
    }

    public function passes($attribute, $value)
    {
        // Check if the current status is 'in_progress' and the new status is 'open'
        return !($this->malfunction->status === 'in_progress' && $value === 'open');
    }

    public function message()
    {
        return 'Você não pode reverter o status de "in_progress" para "open".';
    }
}
