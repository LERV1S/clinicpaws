@extends('layouts.app') <!-- Extiende el layout app.blade.php -->

@section('title', 'ClinicPaws | Bienvenido al Dashboard') <!-- Define el título de la página -->

@section('content') <!-- Sección de contenido -->

<div class="container mx-auto py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                    <!-- Puedes agregar otros enlaces aquí -->
                    @livewire('dashboard-inicio')
    </div>
</div>

@endsection
