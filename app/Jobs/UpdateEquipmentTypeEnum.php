<?php
namespace App\Jobs;

use App\Console\Commands\GenerateEquipmentTypeEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateEquipmentTypeEnum implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Instanciar o comando existente
        $command = new GenerateEquipmentTypeEnum();

        // Executar o método handle do comando
        $command->handle();
    }
}
