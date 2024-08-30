@extends('layouts.app')

@section('content')
    <h1>Manage Pets</h1>

    <!-- Incluye el componente Livewire PetManager -->
    @livewire('inventory-manager')
@endsection
