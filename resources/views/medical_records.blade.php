@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Medical Records</h1>
            
            <!-- Formulario de gestión de registros médicos -->
            <form class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <select class="input-field">
                        <option>Select Pet</option>
                        <!-- Otras opciones -->
                    </select>
                    <select class="input-field">
                        <option>Select Veterinarian</option>
                        <!-- Otras opciones -->
                    </select>
                    <input type="date" class="input-field">
                    <textarea class="input-field" placeholder="Diagnosis"></textarea>
                    <textarea class="input-field" placeholder="Treatment"></textarea>
                </div>
                <div class="flex justify-start mt-4">
                    <button class="cta-button">Add Record</button>
                </div>
            </form>
        </div>
    </div>
@endsection
