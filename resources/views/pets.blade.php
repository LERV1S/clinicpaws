@extends('layouts.app')
@section('title', 'ClinicPaws | Pets')
@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <!-- Incluye el componente Livewire PetManager -->
        @livewire('pet-manager')
    </div>
</div>
@endsection