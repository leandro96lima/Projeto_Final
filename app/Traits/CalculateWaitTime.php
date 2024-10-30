<?php

namespace App\Traits;

use Carbon\Carbon;

trait CalculateWaitTime
{
    private function calculateWaitTime($ticket): int
    {
        if (!$ticket) {
            return 0;
        }

        $openDate = Carbon::parse($ticket->open_date);

        return match ($ticket->status) {
            'open' => $openDate->diffInMinutes(now()),
            'in_progress', 'closed' => $ticket->progress_date
                ? $openDate->diffInMinutes(Carbon::parse($ticket->progress_date))
                : 0,
            default => 0,
        };
    }
}
