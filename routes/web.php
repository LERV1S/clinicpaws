<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;

use App\Models\Appointment;
use Illuminate\Http\Request;

Route::view('/', 'welcome');
// Rutas generales
Route::view('/', 'welcome')->name('welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    
//Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/appointments', [DashboardController::class, 'getAppointments']);


// Rutas con restricciones
Route::get('/pets', function () {
    return view('pets');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage pets')->name('pets.index');

Route::get('/appointments-data', [DashboardController::class, 'getAppointments']);

Route::get('/appointments', function () {
    return view('appointments');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage appointments')->name('appointments.index');

Route::get('/medical_records', function () {
    return view('medical_records');  // Carga la vista que contiene el componente Livewire
})->middleware('can:view medical history')->name('medical_records.index');

Route::get('/clients', function () {
    return view('clients');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage users')->name('clients.index');

Route::get('/veterinarians', function () {
    return view('veterinarians');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage users')->name('veterinarians.index');

Route::get('/employees', function () {
    return view('employees');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage users')->name('employees.index');

Route::get('/inventories', function () {
    return view('inventories');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage inventory')->name('inventories.index');

Route::get('/invoices', function () {
    return view('invoices');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage invoices')->name('invoices.index');

Route::get('/cages', function () {
    return view('cages');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage cages')->name('cages.index');

Route::get('/tickets', function () {
    return view('tickets');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage tickets')->name('tickets.index');

Route::get('/prescriptions', function () {
    return view('prescriptions');  // Carga la vista que contiene el componente Livewire
})->middleware('can:manage prescriptions')->name('prescriptions.index');

// Rutas para descargar el PDF de un ticket
Route::get('tickets/{id}/download', [TicketController::class, 'downloadPDF'])
    ->middleware('can:view tickets')->name('tickets.download');

Route::get('appointments/{id}/download', [AppointmentController::class, 'downloadPDF'])
    ->middleware('can:view appointments')->name('appointments.download');

// el yunjeon
Route::get('/acerca-de', function () {
    return view('acerca-de'); // Nombre de la vista que vamos a crear en la carpeta resources/views navbar "acerca de"
})->name('about');

Route::get('/servicios', function () {
    return view('servicios'); // Nombre de la vista que vamos a crear en la carpeta resources/views navbar "acerca de"
})->name('services');


// esto ya no se utiliza contactos
Route::get('/contactos', function () {
    return view('contactos'); // Nombre de la vista que vamos a crear en la carpeta resources/views navbar "acerca de"
})->name('contacts');

Route::get('/faqs', function () {
    return view('faqs'); // Nombre de la vista que vamos a crear en la carpeta resources/views navbar "acerca de"
})->name('faqs');

// Ruta para descargar el PDF de un ticket
Route::get('tickets/{id}/download', [TicketController::class, 'downloadPDF'])->name('tickets.download');

Route::get('prescriptions/{id}/download', [PrescriptionController::class, 'downloadPDF'])
    ->middleware('can:view prescriptions')->name('prescriptions.download');

Route::get('invoices/{id}/download', [InvoiceController::class, 'downloadPDF'])
    ->middleware('can:view invoices')->name('invoices.download');


require __DIR__.'/auth.php';
