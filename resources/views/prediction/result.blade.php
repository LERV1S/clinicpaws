@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Resultado de la Predicción</h1>

        {{-- Mostrar el mensaje interpretado basado en la predicción --}}
        <p>{{ $interpretation }}</p>
    </div>
@endsection
