<?php

namespace App\Notifications;

use App\Models\Equipment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EquipmentCreatedNotification extends Notification
{
    use Queueable;

    protected $equipment;

    public function __construct(Equipment $equipment)
    {
        $this->equipment = $equipment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Novo Equipamento Criado')
            ->greeting('Olá Admin,')
            ->line('Um novo equipamento foi criado no sistema.')
            ->line('Tipo: ' . $this->equipment->type)
            ->line('Número de Série: ' . $this->equipment->serial_number);
    }
}
