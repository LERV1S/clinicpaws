@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Resultado de la Predicción</h1>

        {{-- Mostrar el mensaje interpretado basado en la predicción --}}
        <p>{{ $interpretation }}</p>

        {{-- Mostrar el valor de la predicción para referencia (opcional) --}}
        <p><strong>Predicción numérica:</strong> {{ $prediction }}</p>
    </div>
@endsection
