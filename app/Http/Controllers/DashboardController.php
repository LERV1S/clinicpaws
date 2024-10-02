<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Veterinarian;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener todas las citas
        $appointments = Appointment::all(['title', 'appointment_date as start', 'appointment_date as end', 'veterinarian_id', 'color']);
        
        // Pasar los eventos a la vista
        return view('dashboard', ['appointments' => $appointments]);
    }

    public function getAppointments(Request $request)
{
    // Definir el rango de fechas (opcional, según la vista actual)
    $startDate = $request->query('start');
    $endDate = $request->query('end');

    // Obtener todas las citas dentro del rango de fechas si se proporcionan
    if ($startDate && $endDate) {
        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])->get();
    } else {
        $appointments = Appointment::all(); // Obtener todas las citas si no se proporciona el rango
    }

    // Obtener todos los veterinarios con la relación al usuario (nombre)
    $veterinarians = Veterinarian::with('user')->get(); // Asumiendo que la relación con usuario es 'user'

    // Preparar el array de eventos para el calendario
    $events = [];
    foreach ($appointments as $appointment) {
        $start = new \DateTime($appointment->appointment_date);
        $end = clone $start;
        $end->modify('+59 minutes'); // Duración de 59 minutos para la cita

        // Obtener el veterinario relacionado con la cita
        $veterinarian = Veterinarian::find($appointment->veterinarian_id);
        $veterinarianName = $veterinarian && $veterinarian->user ? $veterinarian->user->name : 'Veterinario no encontrado';

        $events[] = [
            'title' => 'Cita con ' . $veterinarianName, // Mostrar el nombre del veterinario
            'start' => $start->format('Y-m-d\TH:i:s'),
            'end'   => $end->format('Y-m-d\TH:i:s'),
            'veterinarian_id' => $appointment->veterinarian_id,
            'color' => 'red' // Las citas ocupadas se muestran en rojo
        ];
    }

    // Crear un array con los veterinarios para enviarlos también
    $veterinarianData = [];
    foreach ($veterinarians as $veterinarian) {
        $veterinarianData[] = [
            'id' => $veterinarian->id,
            'name' => $veterinarian->user ? $veterinarian->user->name : 'Sin nombre' // Obtener el nombre del usuario relacionado
        ];
    }

    // Generar los eventos disponibles para cada veterinario si no está ocupado
    foreach ($veterinarians as $veterinarian) {
        $availableTimeslots = [];
        $times = [
            '08:00', '09:00', '10:00', '11:00', '12:00',
            '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'
        ];

        // Generar todas las horas disponibles a partir de la fecha actual
        $currentDate = new \DateTime();
        for ($day = 0; $day < 7; $day++) { // Limitar a una semana
            foreach ($times as $time) {
                $dateTime = new \DateTime($currentDate->format('Y-m-d') . ' ' . $time);

                // Verificar si este veterinario ya tiene una cita a esta hora
                $isOccupied = $appointments->filter(function ($appointment) use ($dateTime, $veterinarian) {
                    return $appointment->veterinarian_id == $veterinarian->id &&
                        (new \DateTime($appointment->appointment_date))->format('Y-m-d H:i') == $dateTime->format('Y-m-d H:i');
                })->isNotEmpty();

                // Si el veterinario no está ocupado, añadir el slot como disponible
                if (!$isOccupied) {
                    $availableTimeslots[] = [
                        'title' => 'Disponible ' . $veterinarian->user->name,
                        'start' => $dateTime->format('Y-m-d\TH:i:s'),
                        'end' => $dateTime->modify('+59 minutes')->format('Y-m-d\TH:i:s'),
                        'color' => 'green',
                        'veterinarian_id' => $veterinarian->id
                    ];
                }
            }

            // Incrementar el día
            $currentDate->modify('+1 day');
        }

        // Agregar los horarios disponibles al array de eventos
        $events = array_merge($events, $availableTimeslots);
    }

    
    // Retornar tanto las citas como los veterinarios
    return response()->json([
        'appointments' => $events,
        'veterinarians' => $veterinarianData
    ]);
}

}
