<?php

namespace App\Jobs;

use App\Notifications\EquipmentRequestRejected;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEquipmentRequestRejectedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $user;

    public function __construct( $user)
    {

        $this->user = $user;
    }

    public function handle()
    {
        // Envia a notificação por e-mail usando o método notify
        $this->user->notify(new EquipmentRequestRejected());
    }
}
