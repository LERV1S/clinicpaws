@extends('layouts.app')
@section('title', 'ClinicPaws | Clients')
@section('content')
    <h1>Manage Clients</h1>

    <!-- Incluye el componente Livewire PetManager -->
    @livewire('client-manager')
@endsection
