@extends('layouts.app')
@section('title', 'ClinicPaws | Tickets')
@section('content')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <!-- Incluye el componente Livewire TicketManager -->
            @livewire('ticket-manager')
        </div>
    </div>
@endsection
