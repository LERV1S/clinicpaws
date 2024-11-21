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

        try {
            // Enviar los datos a la API Flask
            $response = Http::post('http://184.169.254.251:5000/predict', [
                'animal' => $animal,
                'symptoms' => $symptoms,
            ]);

            // Verificar si la respuesta fue exitosa
            if ($response->failed()) {
                return back()->withErrors(['error' => 'La API de predicción falló. Por favor, intenta de nuevo.']);
            }

            // Interpretar el resultado de la predicción
            $prediction = $response->json()['prediction'];
            $interpretation = '';

            if ($prediction == 1) {
                $interpretation = "Alto riesgo para la salud. Se recomienda acudir al veterinario lo más pronto posible.";
            } elseif ($prediction == 0) {
                $interpretation = "Bajo riesgo para la salud. Monitorea al animal y acude al veterinario si los síntomas persisten.";
            } else {
                $interpretation = "Predicción desconocida.";
            }

            // Retornar la vista con el resultado interpretado
            return view('prediction.result', [
                'interpretation' => $interpretation,
                'prediction' => $prediction
            ]);

        } catch (\Exception $e) {
            // Manejar errores en la conexión con la API
            return back()->withErrors(['error' => 'Hubo un error al conectarse con la API de predicción.']);
        }
    }
}
