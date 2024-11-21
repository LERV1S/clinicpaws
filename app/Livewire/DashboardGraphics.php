<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Veterinarian;
use App\Models\User;
use App\Models\Pet;
use Carbon\Carbon;

class DashboardGraphics extends Component
{
    public $appointmentsByVeterinarian = []; // Datos para la gráfica
    public $appointmentsByWeek = []; // Datos para la gráfica de citas por semana
    public $activeUsersData = []; // Datos para la gráfica
    public $inactiveUsersData = []; // Usuarios sin actividad
    public $animalsBySpecies = []; // Datos para la gráfica

    public $revenueByPeriod = []; // Datos para la gráfica
    public $period = 'month'; // Periodo por defecto (day, week, month)

    public function mount()
    {
        $this->loadAppointmentsByVeterinarian();
        $this->loadAppointmentsByMonth(); // Cargar datos para la gráfica de semanas
        $this->loadAppointmentsByStatus(); // Gráfica de estados
        $this->loadAppointmentsByWeek(); // Gráfica de estados
        $this->loadAppointmentsByPaymentMethod(); // Gráfica de métodos de pago
        $this->loadAppointmentsByHour(); // Nueva función
        $this->loadAppointmentsByDayOfWeek(); // Nueva función
        $this->loadActiveUsers();
        $this->loadAnimalsBySpecies();
        $this->loadRevenueByPeriod();
        

    }
    public function updatedPeriod()
    {
        $this->loadRevenueByPeriod();
    }

    public function loadRevenueByPeriod()
    {
        $appointments = Appointment::whereNotNull('payment_amount') // Solo citas con pago
            ->get();

        if ($this->period === 'day') {
            // Agrupar ingresos por día
            $grouped = $appointments->groupBy(function ($appointment) {
                return Carbon::parse($appointment->appointment_date)->format('Y-m-d'); // Ejemplo: "2024-11-18"
            });
        } elseif ($this->period === 'week') {
            // Agrupar ingresos por semana
            $grouped = $appointments->groupBy(function ($appointment) {
                return Carbon::parse($appointment->appointment_date)->format('o-W'); // Año-Semana, Ejemplo: "2024-W46"
            });
        } elseif ($this->period === 'month') {
            // Agrupar ingresos por mes
            $grouped = $appointments->groupBy(function ($appointment) {
                return Carbon::parse($appointment->appointment_date)->format('F Y'); // Ejemplo: "Noviembre 2024"
            });
        }

        // Mapear los datos a un formato adecuado para la gráfica
        $this->revenueByPeriod = $grouped->map(function ($appointments, $period) {
            return [
                'period' => $period, // Día, semana o mes
                'total' => $appointments->sum('payment_amount'), // Sumar los ingresos
            ];
        })->values()->toArray(); // Convertir a un array para el frontend
    }

    public function loadAppointmentsByVeterinarian()
    {
        // Crear un array para almacenar los datos
        $appointmentsData = [];

        // Obtener todos los veterinarios con sus usuarios relacionados
        $veterinarians = Veterinarian::with('user')->get();

        // Contar las citas por veterinario
        $appointmentCounts = Appointment::selectRaw('veterinarian_id, COUNT(*) as total')
            ->groupBy(groups: 'veterinarian_id')
            ->pluck('total', 'veterinarian_id'); // Devuelve un array clave-valor: [veterinarian_id => total]

        // Combinar los datos de veterinarios y citas
        foreach ($veterinarians as $veterinarian) {
            $appointmentsData[] = [
                'name' => $veterinarian->user->name ?? 'Sin Nombre', // Nombre del veterinario
                'total' => $appointmentCounts[$veterinarian->user_id] ?? 0, // Total de citas, o 0 si no tiene citas
            ];
        }

        // Asignar los datos a la variable pública
        $this->appointmentsByVeterinarian = $appointmentsData;
    }
    public function loadAppointmentsByWeek()
    {
        // Obtener citas agrupadas por semana
        $appointmentsByWeek = Appointment::selectRaw('YEARWEEK(appointment_date, 1) as week, COUNT(*) as total')
            ->groupBy('week')
            ->pluck('total', 'week'); // Devuelve un array clave-valor: [week => total]

        // Convertir a un formato adecuado para la gráfica
        $this->appointmentsByWeek = $appointmentsByWeek->map(function ($total, $week) {
            return [
                'week' => $week, // Semana del año
                'total' => $total, // Total de citas
            ];
        })->values()->toArray(); // Convertimos a array para el frontend
    }

    public function loadAppointmentsByMonth()
    {
        // Obtener todas las citas
        $appointments = Appointment::all();
    
        // Agrupar citas por mes y año
        $appointmentsByMonth = $appointments->groupBy(function ($appointment) {
            return Carbon::parse($appointment->appointment_date)->format('F Y'); // Ejemplo: "Enero 2024"
        });
    
        // Mapear los datos a un formato adecuado para la gráfica
        $this->appointmentsByMonth = $appointmentsByMonth->map(function ($appointments, $month) {
            return [
                'month' => $month, // Mes y año
                'total' => $appointments->count(), // Total de citas en ese mes
            ];
        })->values()->toArray(); // Convertir a un array para el frontend
    }

    public function loadAppointmentsByStatus()
{
    // Consultar las citas agrupadas por estado
    $appointmentsByStatus = Appointment::select('status', \DB::raw('COUNT(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status'); // Devuelve un array clave-valor: [status => total]

    // Convertir los datos a un formato adecuado para la gráfica
    $this->appointmentsByStatus = $appointmentsByStatus->map(function ($total, $status) {
        return [
            'status' => ucfirst($status), // Capitalizar la primera letra del estado
            'total' => $total, // Total de citas por estado
        ];
    })->values()->toArray(); // Convertimos a array para el frontend
}

public function loadAppointmentsByPaymentMethod()
{
    // Consultar las citas agrupadas por método de pago
    $appointmentsByPaymentMethod = Appointment::select('payment_method', \DB::raw('COUNT(*) as total'))
        ->whereNotNull('payment_method') // Ignorar citas sin método de pago
        ->groupBy('payment_method')
        ->pluck('total', 'payment_method'); // Devuelve un array clave-valor: [payment_method => total]

    // Convertir los datos a un formato adecuado para la gráfica
    $this->appointmentsByPaymentMethod = $appointmentsByPaymentMethod->map(function ($total, $method) {
        return [
            'method' => ucfirst($method), // Capitalizar la primera letra del método
            'total' => $total, // Total de citas por método
        ];
    })->values()->toArray(); // Convertimos a array para el frontend
}

public function loadAppointmentsByHour()
{
    // Crear un array para almacenar los datos
    $appointmentsData = [];

    // Obtener todas las citas
    $appointments = Appointment::all();

    // Agrupar las citas por hora
    $appointmentsByHour = $appointments->groupBy(function ($appointment) {
        return Carbon::parse($appointment->appointment_date)->format('H'); // Solo la hora (24 horas)
    });

    // Mapear los datos a un formato adecuado para la gráfica y ordenarlos
    $this->appointmentsByHour = $appointmentsByHour->map(function ($appointments, $hour) {
        return [
            'hour' => $hour, // Hora del día
            'total' => $appointments->count(), // Total de citas en esa hora
        ];
    })->sortByDesc('total') // Ordenar de mayor a menor por total
    ->values()->toArray(); // Convertir a un array para el frontend
}
public function loadAppointmentsByDayOfWeek()
{
    // Crear un array para almacenar los datos
    $appointmentsData = [];

    // Obtener todas las citas
    $appointments = Appointment::all();

    // Agrupar las citas por día de la semana
    $appointmentsByDayOfWeek = $appointments->groupBy(function ($appointment) {
        // Obtenemos el nombre del día en formato largo (Lunes, Martes, etc.)
        return Carbon::parse($appointment->appointment_date)->locale('es')->dayName;
    });

    // Mapear los datos a un formato adecuado para la gráfica
    $this->appointmentsByDayOfWeek = $appointmentsByDayOfWeek->map(function ($appointments, $day) {
        return [
            'day' => ucfirst($day), // Día de la semana con mayúscula inicial
            'total' => $appointments->count(), // Total de citas en ese día
        ];
    })->sortByDesc('total') // Ordenar por cantidad de citas en orden descendente
    ->values()->toArray(); // Convertir a un array para el frontend
}

public function loadActiveUsers()
{
    // Obtener los dueños que tienen citas (Usuarios Activos)
    $activeUserIds = Appointment::join('pets', 'appointments.pet_id', '=', 'pets.id')
        ->join('users', 'pets.owner_id', '=', 'users.id')
        ->distinct('users.id') // Usuarios únicos
        ->pluck('users.id')
        ->toArray();

    // Contar usuarios activos
    $activeUsersCount = count($activeUserIds);

    // Contar usuarios no activos
    $totalUsers = User::count();
    $inactiveUsersCount = $totalUsers - $activeUsersCount;

    // Preparar datos para la gráfica
    $this->activeUsersData = [
        ['status' => 'Activos', 'total' => $activeUsersCount],
        ['status' => 'Inactivos', 'total' => $inactiveUsersCount],
    ];
}
public function loadAnimalsBySpecies()
    {
        // Agrupar animales por especie y contar la cantidad
        $this->animalsBySpecies = Pet::selectRaw('species, COUNT(*) as total')
            ->groupBy('species')
            ->pluck('total', 'species') // Devuelve un array clave-valor: [species => total]
            ->map(function ($total, $species) {
                return [
                    'species' => ucfirst($species), // Capitaliza el nombre de la especie
                    'total' => $total,
                ];
            })
            ->values()
            ->toArray(); // Convertimos a array para el frontend
    }
    
   
    public function render()
    {
        return view('livewire.dashboard-graphics', [
            'appointmentsByVeterinarian' => $this->appointmentsByVeterinarian,
            'appointmentsByWeek' => $this->appointmentsByWeek,
            'appointmentsByMonth' => $this->appointmentsByMonth, 
            'appointmentsByStatus'=> $this->appointmentsByStatus,
            'appointmentsByPaymentMethod'=> $this->appointmentsByPaymentMethod,
            'appointmentsByHour'=> $this->appointmentsByHour,
            'appointmentsByDayOfWeek'=> $this->appointmentsByDayOfWeek,
            'activeUsersData' => $this->activeUsersData,
            'animalsBySpecies' => $this->animalsBySpecies,
            'revenueByPeriod' => $this->revenueByPeriod,
            'period' => $this->period,

        ]);
    }

}