@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Formulario de Predicción</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('predict') }}">
            @csrf
            <div class="form-group">
                <label for="animal">Animal</label>
                <input type="text" class="form-control" name="animal" id="animal" required>
            </div>

            <div class="form-group">
                <label for="symptoms">Síntomas</label>
                <input type="text" class="form-control" name="symptoms[]" placeholder="Síntoma 1" required>
                <input type="text" class="form-control" name="symptoms[]" placeholder="Síntoma 2">
                <input type="text" class="form-control" name="symptoms[]" placeholder="Síntoma 3">
                <input type="text" class="form-control" name="symptoms[]" placeholder="Síntoma 4">
                <input type="text" class="form-control" name="symptoms[]" placeholder="Síntoma 5">
            </div>

            <button type="submit" class="btn btn-primary">Predecir</button>
        </form>
    </div>
@endsection
