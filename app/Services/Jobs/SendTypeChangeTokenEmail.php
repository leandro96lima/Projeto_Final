<?php

namespace App\Jobs;

use App\Mail\TokenMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
        Mail::to($this->email)->send(new TokenMail($this->token));
    }
}
