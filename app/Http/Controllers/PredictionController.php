<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    public function predict(Request $request)
    {
        // Validar la entrada del usuario
        $request->validate([
            'animal' => 'required|string',
            'symptoms' => 'required|array|max:5',
        ]);

        // Obtener los valores del formulario
        $animal = $request->input('animal');
        $symptoms = $request->input('symptoms');

        // Enviar los datos a la API Flask
        $response = Http::post('http://18.219.252.105:5000/predict', [
            'animal' => $animal,
            'symptoms' => $symptoms,
        ]);

        // Manejar errores de la API
        if ($response->failed()) {
            return back()->withErrors(['error' => 'La API de predicción falló.']);
        }

        // Interpretar el resultado de la predicción
        $prediction = $response->json()['prediction'];
        
        $interpretation = '';
        if ($prediction == 1) {
            $interpretation = "Se recomienda acudir al veterinario lo más pronto posible.";
        } elseif ($prediction == 0) {
            $interpretation = "Monitorea al animal y acude al veterinario si los síntomas persisten.";
        } else {
            $interpretation = "Predicción desconocida.";
        }

        // Retornar la vista con el resultado de la predicción interpretado
        return view('prediction.result', ['interpretation' => $interpretation]);
    }
}
