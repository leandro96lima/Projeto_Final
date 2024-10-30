<?php

namespace App\Traits;

use Carbon\Carbon;

trait CalculateResolutionTime
{
    private function calculateResolutionTime($ticket): int
    {
        if (!$ticket || !$ticket->progress_date || !$ticket->close_date) {
            return 0;
        }

        $progressDate = Carbon::parse($ticket->progress_date);
        $closeDate = Carbon::parse($ticket->close_date);

        return $progressDate->diffInMinutes($closeDate);
    }
}
