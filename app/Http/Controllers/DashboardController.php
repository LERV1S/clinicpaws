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
        $veterinarians = Veterinarian::with('user')->get();
    
        // Preparar el array de eventos para el calendario
        $events = [];
    
        // Primero agregar las citas ocupadas (en rojo)
        foreach ($appointments as $appointment) {
            $start = new \DateTime($appointment->appointment_date);
            $end = clone $start;
            $end->modify('+59 minutes'); // Duración de 59 minutos para la cita
    
            // Buscar el veterinario por el user_id (veterinarian_id en appointments es ahora user_id)
            $veterinarian = Veterinarian::where('user_id', $appointment->veterinarian_id)->first();
            $veterinarianName = $veterinarian && $veterinarian->user ? $veterinarian->user->name : 'Veterinario no encontrado';
    
            $events[] = [
                'title' => 'Cita con ' . $veterinarianName,
                'start' => $start->format('Y-m-d\TH:i:s'),
                'end'   => $end->format('Y-m-d\TH:i:s'),
                'veterinarian_id' => $appointment->veterinarian_id, // Este es el user_id
                'color' => 'red' // Las citas ocupadas se muestran en rojo
            ];
        }
    
        // Obtener la fecha de hoy y limitar las citas a solo los próximos 7 días
        $today = new \DateTime();
        $maxDate = (clone $today)->modify('+7 days'); // 7 días a partir de hoy
    
        // Generar las citas disponibles (en verde) solo para los próximos 7 días que trabaja el veterinario
        $times = [
            '08:00', '09:00', '10:00', '11:00', '12:00',
            '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'
        ];
    
        foreach ($veterinarians as $veterinarian) {
            $currentDate = clone $today; // Empezar desde hoy
    
            while ($currentDate <= $maxDate) {
                $dayOfWeek = $currentDate->format('N'); // 1 = Lunes, 7 = Domingo
    
                // Verificar si el veterinario trabaja en este día
                $worksToday = false;
                switch ($dayOfWeek) {
                    case 1:
                        $worksToday = $veterinarian->works_on_monday;
                        break;
                    case 2:
                        $worksToday = $veterinarian->works_on_tuesday;
                        break;
                    case 3:
                        $worksToday = $veterinarian->works_on_wednesday;
                        break;
                    case 4:
                        $worksToday = $veterinarian->works_on_thursday;
                        break;
                    case 5:
                        $worksToday = $veterinarian->works_on_friday;
                        break;
                    case 6:
                        $worksToday = $veterinarian->works_on_saturday;
                        break;
                    case 7:
                        $worksToday = $veterinarian->works_on_sunday;
                        break;
                }
    
                // Si el veterinario trabaja en este día, generar las citas disponibles
                if ($worksToday) {
                    foreach ($times as $time) {
                        $dateTime = new \DateTime($currentDate->format('Y-m-d') . ' ' . $time);
    
                        // Verificar si este veterinario ya tiene una cita a esta hora
                        $isOccupied = $appointments->filter(function ($appointment) use ($dateTime, $veterinarian) {
                            return $appointment->veterinarian_id == $veterinarian->user_id && // Comparar con el user_id
                                (new \DateTime($appointment->appointment_date))->format('Y-m-d H:i') == $dateTime->format('Y-m-d H:i');
                        })->isNotEmpty();
    
                        // Si el veterinario no está ocupado, añadir el slot como disponible
                        if (!$isOccupied) {
                            $events[] = [
                                'title' => 'Disponible ' . $veterinarian->user->name,
                                'start' => $dateTime->format('Y-m-d\TH:i:s'),
                                'end' => $dateTime->modify('+59 minutes')->format('Y-m-d\TH:i:s'),
                                'color' => 'green',
                                'veterinarian_id' => $veterinarian->user_id // Aquí también se usa el user_id
                            ];
                        }
                    }
                }
    
                // Incrementar el día
                $currentDate->modify('+1 day');
            }
        }
    
        // Retornar tanto las citas como los veterinarios
        return response()->json([
            'appointments' => $events,
            'veterinarians' => $veterinarians
        ]);
    }
    
    

}
