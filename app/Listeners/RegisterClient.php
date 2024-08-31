<?php

namespace App\Listeners;

use App\Models\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class RegisterClient
{
    public function handle(Registered $event)
    {
        $user = $event->user;

        // Verificar si el usuario tiene el rol de 'Cliente'
        if ($user->hasRole('Cliente')) {
            // Crear un registro en la tabla 'clients'
            Client::create([
                'user_id' => $user->id,
                // Otros campos opcionales
            ]);

            // Agrega un log para verificar que el listener se ejecuta
            Log::info('RegisterClient ejecutado para el usuario: ' . $user->id);
        }
    }
}