@extends('layouts.app') <!-- Extiende el layout app2.blade.php -->

@section('title', 'ClinicPaws | Dashboard') <!-- Define el título de la página -->

@section('content') <!-- Sección de contenido -->

<div class="container mx-auto py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Aquí el calendario se renderizará desde el componente Livewire -->
                
                @livewire('dashboard-component')
            </div>
        </div>
    </div>
</div>

@endsection
