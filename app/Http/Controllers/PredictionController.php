<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    public function predictDangerous(Request $request)
    {
        // Preparar los datos de los síntomas y el nombre del animal desde el formulario o API de Laravel
        $data = [
            'AnimalName' => $request->AnimalName,
            'symptoms1' => $request->symptoms1,
            'symptoms2' => $request->symptoms2,
            'symptoms3' => $request->symptoms3,
            'symptoms4' => $request->symptoms4,
            'symptoms5' => $request->symptoms5,
        ];

        // Enviar la solicitud a la API Flask
        $response = Http::post('http://<EC2_IP>:5000/predict', $data);

        // Obtener la respuesta de la API
        $prediction = $response->json();

        // Mostrar la predicción en una vista
        return view('result', ['dangerous' => $prediction['dangerous']]);
    }
}

