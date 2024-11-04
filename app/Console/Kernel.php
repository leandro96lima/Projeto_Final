<?php
namespace App\Console;

use App\Jobs\UpdateEquipmentTypeEnum;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
protected function schedule(Schedule $schedule)
{
// Executa o Job a cada 14 dias
$schedule->job(new UpdateEquipmentTypeEnum)->cron('0 0 */14 * *');
}

protected function commands()
{
$this->load(__DIR__.'/Commands');

}

}
