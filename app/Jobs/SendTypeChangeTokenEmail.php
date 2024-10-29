<?php

namespace App\Jobs;

use App\Mail\TokenMail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTypeChangeTokenEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $token;

    /**
     * Cria uma nova instância do job.
     *
     * @param string $email
     * @param string $token
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Executa o job.
     */
    public function handle()
    {
        try {
            Mail::to($this->email)->send(new TokenMail($this->token));
        } catch (Exception $e) {
            // Registra o erro para monitoramento
            Log::error("Falha ao enviar o e-mail de token: " . $e->getMessage());
            // Você também pode lançar a exceção novamente para que o job tente ser reprocessado
            throw $e;
        }
    }
}
