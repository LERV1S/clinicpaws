@extends('layouts.app')
@section('title', 'ClinicPaws | Cages')
@section('content')
    <h1>Manage Pets</h1>

    <!-- Incluye el componente Livewire PetManager -->
    @livewire('cage-manager')
@endsection
