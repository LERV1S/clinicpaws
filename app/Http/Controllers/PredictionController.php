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
            'symptoms' => 'required|array|max:5', // Un máximo de 5 síntomas
        ]);

        // Obtener los valores del formulario
        $animal = $request->input('animal');
        $symptoms = $request->input('symptoms');

        try {
            // Enviar los datos a la API Flask
            $response = Http::post('http://184.169.254.251:5000/predict', [
                'animal' => $animal,
                'symptoms' => $symptoms,
            ]);

            // Verificar si la API respondió con éxito
            if ($response->failed()) {
                return back()->withErrors(['error' => 'La API de predicción falló.']);
            }

            // Interpretar el resultado de la predicción
            $prediction = $response->json()['prediction'] ?? null;

            $interpretation = match ($prediction) {
                1 => "Se recomienda acudir al veterinario lo más pronto posible.",
                0 => "Monitorea al animal y acude al veterinario si los síntomas persisten.",
                default => "Predicción desconocida.",
            };

            // Retornar la vista con el resultado de la predicción interpretado
            return view('prediction.result', ['interpretation' => $interpretation]);
        } catch (\Exception $e) {
            // Manejar cualquier error
            return back()->withErrors(['error' => 'Hubo un error al conectarse a la API de predicción.']);
        }
    }
}
