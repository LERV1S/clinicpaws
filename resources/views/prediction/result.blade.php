@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Resultado de la predicción</h1>
        <p>{{ $interpretation }}</p>
        <a href="{{ route('predict') }}" class="btn btn-secondary">Volver</a>
    </div>
@endsection
