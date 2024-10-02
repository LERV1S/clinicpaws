<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Veterinarian;

class DashboardComponent extends Component
{
    public $veterinarian_id;
    public $appointment_date;
    public $appointments = [];

    public function mount()
    {
        // Cargar las citas desde la base de datos
        $this->appointments = Appointment::with('veterinarian.user')->get()->map(function ($appointment) {
            return [
                'title' => 'Cita con ' . ($appointment->veterinarian->user->name ?? 'Veterinario'),
                'start' => $appointment->appointment_date,
                'veterinarian_id' => $appointment->veterinarian_id,
                'color' => 'red', // Color de la cita
            ];
        })->toArray(); // Convertimos el resultado a array para pasarlo a la vista
    }
    protected $listeners = ['fillAppointmentFields'];

    public function fillAppointmentFields($data)
    {
        $this->veterinarian_id = $data['veterinarian_id'];
        $this->appointment_date = \Carbon\Carbon::parse($data['appointment_date'])->format('Y-m-d\TH:i');
    }
    
    public function createAppointment(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'veterinarian_id' => 'required|exists:veterinarians,id',
            'appointment_date' => 'required|date',
        ]);

        // Crear una nueva cita
        $appointment = Appointment::create([
            'veterinarian_id' => $validatedData['veterinarian_id'],
            'appointment_date' => $validatedData['appointment_date'],
            'status' => 'Solicitada', // Por defecto
        ]);

        // Retornar respuesta JSON con el ID de la cita creada
        return response()->json([
            'success' => true,
            'appointment_id' => $appointment->id
        ]);
        
    }
    public function getAppointments(Request $request)
    {
        // Validar los parámetros de fecha que envía FullCalendar
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        // Obtener las citas entre las fechas indicadas
        $appointments = Appointment::whereBetween('appointment_date', [$request->start, $request->end])
            ->get(['title', 'appointment_date as start', 'appointment_date as end', 'veterinarian_id', 'color']);

        // Formatear y devolver las citas en formato JSON
        return response()->json(['appointments' => $appointments]);
    }




    public function render()
    {
        return view('livewire.dashboard-component', [
            'appointments' => $this->appointments
        ]);
    }
}