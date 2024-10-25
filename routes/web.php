<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MalfunctionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TicketController;
use App\Http\Middleware\CheckUserType;
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
    Route::post('/profile/request-token', [ProfileController::class, 'sendTypeChangeToken'])->name('profile.request-token');

    // Rotas para técnicos com middleware CheckUserType
    Route::middleware([CheckUserType::class . ':Admin,Technician'])->group(function () {
        Route::resources([
            'equipments' => EquipmentController::class,
            'malfunctions' => MalfunctionController::class,
            'tickets' => TicketController::class,
            'technicians' => TechnicianController::class
        ]);
        // Adicione mais rotas específicas para técnicos aqui
    });

    Route::get('/tickets/partials/user-create-equipment', function () {
        return view('user-create-equipment'); // Retorna a view do partial
    })->name('user.create.equipment');


});


//Route::middleware('auth', 'is_admin')->prefix('admin')->group(function () {
//    Route::get('type-change-requests', [AdminController::class, 'typeChangeRequests'])->name('admin.type-change-requests');
//    Route::post('type-change-requests/{request}/approve', [AdminController::class, 'approveTypeChangeRequest'])->name('admin.approve-type-change-request');
//    Route::post('type-change-requests/{request}/reject', [AdminController::class, 'rejectTypeChangeRequest'])->name('admin.reject-type-change-request');
//});





require __DIR__.'/auth.php';
