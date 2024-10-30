<?php

namespace App\Notifications;

use App\Models\TypeChangeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TypeChangeRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request; // Melhor prática: Usar protected para variáveis internas

    /**
     * Cria uma nova instância de notificação.
     *
     * @param TypeChangeRequest $request A solicitação de mudança de tipo.
     */
    public function __construct(TypeChangeRequest $request)
    {
        // Inicializa a propriedade $request com o objeto TypeChangeRequest fornecido
        $this->request = $request;
    }

    /**
     * Define os canais pelos quais a notificação será enviada.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Cria a mensagem de e-mail para a notificação.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New User Type Change Request')
            ->line('A user has requested to change their type.')
            ->line('Requested Type: ' . $this->request->requested_type)
            ->line('Reason: ' . $this->request->reason)
            ->action('Review Request', url('/admin/type-change-requests'))
            ->line('Please review and approve or reject the request.');
    }
}

