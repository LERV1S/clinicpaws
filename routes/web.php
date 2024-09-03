<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('/pets', function () {
    return view('pets');  // Carga la vista que contiene el componente Livewire
})->name('pets.index');

Route::get('/appointments', function () {
    return view('appointments');  // Carga la vista que contiene el componente Livewire
})->name('appointments.index');

Route::get('/medical_records', function () {
    return view('medical_records');  // Carga la vista que contiene el componente Livewire
})->name('medical_records.index');

Route::get('/clients', function () {
    return view('clients');  // Carga la vista que contiene el componente Livewire
})->name('clients.index');

Route::get('/veterinarians', function () {
    return view('veterinarians');  // Carga la vista que contiene el componente Livewire
})->name('veterinarians.index');

Route::get('/employees', function () {
    return view('employees');  // Carga la vista que contiene el componente Livewire
})->name('employees.index');

Route::get('/inventories', function () {
    return view('inventories');  // Carga la vista que contiene el componente Livewire
})->name('inventories.index');

Route::get('/invoices', function () {
    return view('invoices');  // Carga la vista que contiene el componente Livewire
})->name('invoices.index');

Route::get('/cages', function () {
    return view('cages');  // Carga la vista que contiene el componente Livewire
})->name('cages.index');

Route::get('/tickets', function () {
    return view('tickets');  // Carga la vista que contiene el componente Livewire
})->name('tickets.index');

Route::get('/prescriptions', function () {
    return view('prescriptions');  // Carga la vista que contiene el componente Livewire
})->name('prescriptions.index');

// Ruta para descargar el PDF de un ticket
Route::get('tickets/{id}/download', [TicketController::class, 'downloadPDF'])->name('tickets.download');

require __DIR__.'/auth.php';
