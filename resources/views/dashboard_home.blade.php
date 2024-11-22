@extends('layouts.app') <!-- Extiende el layout app.blade.php -->

@section('title', 'ClinicPaws | Gráficas') <!-- Define el título de la página -->

@section('content') <!-- Sección de contenido -->

<div class="container mx-auto py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Puedes agregar otros enlaces aquí -->
                    @livewire('dashboard-graphics')
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
