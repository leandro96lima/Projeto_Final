<?php

namespace App\Traits;

use Carbon\Carbon;
trait CalculateTime
{
    private function calculateResolutionTime($ticket): int
    {
        if (!$ticket || $ticket->status === 'open' || !$ticket->progress_date) return 0;

        $progressDate = Carbon::parse($ticket->progress_date);
        $endDate = $ticket->close_date ? Carbon::parse($ticket->close_date)
            : now();


        (int)$time = $progressDate->diffInMinutes($endDate);

            $ticket->resolution_time = $time;
            $ticket->save();


        return $time;
    }


    private function calculateWaitTime($ticket): int
    {
        if (!$ticket) return 0;

        $openDate = Carbon::parse($ticket->open_date);
        $waitDate = $ticket->progress_date ? Carbon::parse($ticket->progress_date)
            : now();

        (int)$time = $openDate->diffInMinutes($waitDate); // Sempre calcula a diferença

            $ticket->wait_time = $time;
            $ticket->save();

        return $time; // Retorna o tempo calculado
    }
}


