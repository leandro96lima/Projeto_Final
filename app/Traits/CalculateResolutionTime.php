<?php

namespace App\Traits;

use Carbon\Carbon;

trait CalculateResolutionTime
{
    private function calculateResolutionTime($ticket): int
    {
        if (!$ticket) {
            return 0;
        }

        $progressDate = Carbon::parse($ticket->progress_date);
        $closeDate = Carbon::parse($ticket->close_date);

        return $ticket->progress_date && $ticket->close_date
            ? $progressDate->diffInMinutes($closeDate)
            : 0;
    }
}
