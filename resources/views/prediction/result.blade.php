@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Resultado de la predicción</h1>

        {{-- Mostrar el mensaje interpretado basado en la predicción --}}
        @if($prediction['prediction'] == 1)
            <p>Alto riesgo para la salud. Se recomienda acudir al veterinario lo más pronto posible.</p>
        @elseif($prediction['prediction'] == 0)
            <p>Bajo riesgo para la salud. Monitorea al animal y acude al veterinario si los síntomas persisten.</p>
        @else
            <p>Predicción desconocida.</p>
        @endif
    </div>
@endsection
