@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Resultado de la Predicción</h1>
            {{-- Mostrar el mensaje interpretado basado en la predicción --}}
            <p class="text-lg font-semibold 
                {{ $prediction == 0 ? 'text-red-600' : ($prediction == 1 ? 'text-green-600' : 'text-gray-500') }}">
                {{ $interpretation }}
            </p>
            {{-- Botón para regresar --}}
            <div class="mt-6">
                <a href="{{ url()->previous() }}" 
                   class="cta-button bg-blue-600 hover:bg-blue-700 text-white">
                    Regresar
                </a>
            </div>
        </div>
    </div>
@endsection
