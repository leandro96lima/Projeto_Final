<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MalfunctionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TicketController;
use App\Http\Middleware\CheckUserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

// Rota principal
Route::get('/', function () {
    return view('welcome');
});

// Rota do dashboard com middleware de autenticação
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rotas que requerem autenticação
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/request-token', [ProfileController::class, 'requestTypeChangeToken'])->name('profile.request-token');



    Route::get('/tickets/partials/user-create-equipment', function () {
        return view('tickets.create'); // Retorna a view do partial
    })->name('user.create.equipment');

    Route::resources([
        'tickets' => TicketController::class,
    ]);

});


Route::middleware(['auth', CheckUserType::class . ':Admin,Technician'])->group(function () {
    Route::resources([
        'malfunctions' => MalfunctionController::class,
        'technicians' => TechnicianController::class,
        'equipments' => EquipmentController::class,
    ]);
});



Route::middleware(['auth', CheckUserType::class . ':Admin'])->group(function () {
    Route::get('/admin/requests', [AdminController::class, 'requests'])->name('admin.requests');
    Route::post('/admin/requests/{request}/approve', [AdminController::class, 'approveTypeChangeRequest'])->name('admin.approve-type-change-request');
    Route::post('/admin/requests/{request}/reject', [AdminController::class, 'rejectTypeChangeRequest'])->name('admin.reject-type-change-request');
    Route::post('/admin/requests/{request}/approve', [AdminController::class, 'approveNewEquipmentRequest'])->name('admin.approve-new-equipment-request');
    Route::post('/admin/requests/{request}/reject', [AdminController::class, 'rejectNewEquipmentRequest'])->name('admin.reject-new-equipment-request');
});

require __DIR__.'/auth.php';
