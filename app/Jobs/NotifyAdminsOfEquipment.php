<?php

namespace App\Jobs;

use App\Models\Equipment;
use App\Models\User;
use App\Notifications\EquipmentCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAdminsOfEquipment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $equipment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Equipment $equipment)
    {
        $this->equipment = $equipment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admins = User::where('type', 'Admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new EquipmentCreatedNotification($this->equipment));
        }
    }
}
