<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EquipmentRequestRejected extends Notification implements ShouldQueue
{
    use Queueable;


    public function __construct()
    {

    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Solicitação Rejeitada')
            ->line('A sua solicitação de adicionar um equipamento novo foi rejeitada. O ticket foi cancelado.')
            ->line('Para mais informações, contacte o administrador.')
            ->line('Obrigado por usar nossa aplicação!');
    }
}
