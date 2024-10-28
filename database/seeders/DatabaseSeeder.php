<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Malfunction;
use App\Models\Equipment;
use App\Models\Technician;
use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
//        User::factory(10)->create();
//        Technician::factory(5)->create();
//        Equipment::factory(10)->create();
//        Ticket::factory(20)->create();
//        Malfunction::factory(20)->create();


        User::factory()->withTechnician([
            'specialty' => 'Tech',
        ])->create([
            'name' => 'Leandro',
            'email' => 'tech@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

//        User::factory()->withAdmin([
//
//        ])->create([
//            'name' => 'Leandro',
//            'email' => 'admin@gmail.com',
//            'password' => Hash::make('123456789'),
//        ]);
    }
}
