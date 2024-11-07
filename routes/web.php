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
    return view('auth.login');
});

Route::get('/dashboard', function() {
    return redirect()->route('tickets.index');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Grupo de rotas que requerem autenticação
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/request-token', [ProfileController::class, 'requestTypeChangeToken'])->name('profile.request-token');


    // Tickets resource with a different URI to avoid conflicts
    Route::prefix('tickets/index')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('tickets.index'); // Tickets index
        Route::get('/create', [TicketController::class, 'create'])->name('tickets.create'); // Create form
        Route::post('/', [TicketController::class, 'store'])->name('tickets.store'); // Store new ticket
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show'); // Show ticket
        Route::get('/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit'); // Edit form
        Route::patch('/{ticket}', [TicketController::class, 'update'])->name('tickets.update'); // Update ticket
        Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy'); // Delete ticket
    });

    Route::get('/tickets/partials/user-create-equipment', function () {
        return view('tickets.create'); // Retorna a view do partial
    })->name('user.create.equipment');
});


Route::middleware(['auth', CheckUserType::class . ':AdminTechnician'])->group(function () {
    Route::resources([
        'malfunctions' => MalfunctionController::class,
        'technicians' => TechnicianController::class,
    ]);
});
Route::middleware(['auth', CheckUserType::class . ':Admin'])->group(function () {

    Route::resources([
        'equipments' => EquipmentController::class,
    ]);

        Route::get('/admin/requests', [AdminController::class, 'requests'])->name('admin.requests');
        // Routes for TypeChangeRequest
        Route::post('/admin/requests/type-change/{request}/approve', [AdminController::class, 'approveTypeChangeRequest'])->name('admin.type-change-requests.approve');
        Route::post('/admin/requests/type-change/{request}/reject', [AdminController::class, 'rejectTypeChangeRequest'])->name('admin.type-change-requests.reject');
        // Routes for NewEquipmentRequest
        Route::post('/admin/requests/new-equipment/{request}/approve', [AdminController::class, 'approveNewEquipmentRequest'])->name('admin.approve-new-equipment-request');
        Route::post('/admin/requests/new-equipment/{request}/reject', [AdminController::class, 'rejectNewEquipmentRequest'])->name('admin.reject-new-equipment-request');
});

require __DIR__.'/auth.php';
