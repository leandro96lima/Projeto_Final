<?php

namespace App\Traits;

use Carbon\Carbon;

trait CalculateResolutionTime
{
    private function calculateResolutionTime($ticket): int
    {
        if (!$ticket || !$ticket->progress_date) {
            return 0;
        }

        $progressDate = Carbon::parse($ticket->progress_date);

        // Calcula em tempo real se o status for in_progress
        if ($ticket->status === 'in_progress') {
            return $progressDate->diffInMinutes(Carbon::now());
        }

        // Se o status for closed, utiliza o valor armazenado
        return $ticket->resolution_time ?? 0;
    }

}
