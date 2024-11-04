<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Malfunction;

class TicketStatusNotPendingApproval implements Rule
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function passes($attribute, $value)
    {
        // You can keep this method if you need to perform validation,
        // but for filtering, you may not need this logic here.
        return true;
    }

    public function message()
    {
        return 'Malfunctions associated with tickets having status "pending_approval" cannot be retrieved.';
    }
}
