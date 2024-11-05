<?php
namespace App\Providers;

use App\Jobs\UpdateEquipmentTypeEnum;
use Illuminate\Support\ServiceProvider;

class ScheduledJobServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Executar o Job na inicialização do aplicativo
        if ($this->isTimeToRunJob()) {
            UpdateEquipmentTypeEnum::dispatch();
        }
    }

    protected function isTimeToRunJob()
    {
        // Lógica para verificar se é hora de executar o Job
        // Você pode armazenar a última execução em um arquivo ou no banco de dados
        // Aqui está um exemplo simples usando um arquivo:

        $lastRunFile = storage_path('last_run.txt');
        $lastRun = file_exists($lastRunFile) ? file_get_contents($lastRunFile) : 0;

        // Tempo atual
        $currentTime = time();

        // Verifica se passaram 14 dias (14 dias * 24 horas * 60 minutos * 60 segundos)
        if (($currentTime - $lastRun) >= (14 * 24 * 60 * 60)) {
            // Atualiza o arquivo com o novo timestamp
            file_put_contents($lastRunFile, $currentTime);
            return true;
        }

        return false;
    }
}
