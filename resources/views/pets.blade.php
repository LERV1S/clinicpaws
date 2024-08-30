@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Pets</h1>
            
            <!-- Incluye el componente Livewire PetManager -->
            <div class="mt-6">
                <form class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <input type="text" class="input-field" placeholder="Name">
                        <input type="text" class="input-field" placeholder="Species">
                        <input type="text" class="input-field" placeholder="Breed">
                        <input type="date" class="input-field">
                        <input type="text" class="input-field" placeholder="Medical Conditions">
                    </div>
                    <div class="flex justify-start mt-4">
                        <button class="cta-button">Add Pet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
