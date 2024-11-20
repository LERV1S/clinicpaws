<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    public function predict(Request $request)
    {
        // Validar la entrada del usuario
        $validatedData = $request->validate([
            'animal' => 'required|string|max:255',
            'symptoms' => 'required|array|max:5', // Máximo de 5 síntomas
            'symptoms.*' => 'string|max:255',    // Cada síntoma debe ser una cadena válida
        ]);

        // Obtener los valores del formulario
        $animal = $validatedData['animal'];
        $symptoms = $validatedData['symptoms'];

        // Rellenar con cadenas vacías si hay menos de 5 síntomas
        $symptoms = array_pad($symptoms, 5, '');

        try {
            // Enviar los datos a la API Flask
            $response = Http::timeout(10)->post('http://184.169.254.251:5000/predict', [
                'animal' => $animal,
                'symptoms' => $symptoms,
            ]);

            // Verificar si la API respondió con éxito
            if ($response->failed()) {
                return back()->withErrors([
                    'error' => 'La API de predicción no respondió correctamente. Verifique los datos o inténtelo más tarde.'
                ]);
            }

            // Interpretar el resultado de la predicción
            $responseData = $response->json();
            $prediction = $responseData['prediction'] ?? null;

            if ($prediction === null) {
                return back()->withErrors([
                    'error' => 'La respuesta de la API es inválida. Inténtelo más tarde.'
                ]);
            }

            $interpretation = match ($prediction) {
                1 => "Se recomienda acudir al veterinario lo más pronto posible.",
                0 => "Monitorea al animal y acude al veterinario si los síntomas persisten.",
                default => "Predicción desconocida. Consulte al veterinario para mayor seguridad.",
            };

            // Retornar la vista con el resultado de la predicción interpretado
            return view('prediction.result', ['interpretation' => $interpretation]);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            // Manejo de errores HTTP específicos
            return back()->withErrors([
                'error' => 'Error al conectarse a la API: ' . $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            // Manejar cualquier otro error
            return back()->withErrors([
                'error' => 'Ocurrió un error inesperado: ' . $e->getMessage(),
            ]);
        }
    }
}
