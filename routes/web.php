<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MalfunctionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/request-token', [ProfileController::class, 'sendTypeChangeToken'])->name('profile.request-token');
});

Route::resources([
    'equipments' => EquipmentController::class,
    'malfunctions' => MalfunctionController::class,
    'tickets' => TicketController::class,
    'technicians' => TechnicianController::class,
]);

require __DIR__.'/auth.php';
