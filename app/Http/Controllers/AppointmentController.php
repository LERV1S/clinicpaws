<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use PDF; // Esto requiere Barryvdh DomPDF
use Illuminate\Http\Request;
use App\Models\Veterinarian;
class AppointmentController extends Controller

{
    /**
     * Display a listing of the resource.
     */
// AppointmentController.php

public function index()
{

}

public function show(Request $request)
{
    $veterinarianId = $request->input('veterinarian_id');
    $appointmentDate = $request->input('appointment_date');

    return view('appointment-manager', [
        'veterinarian_id' => $veterinarianId,
        'appointment_date' => $appointmentDate
    ]);
}
public function showAppointmentManager(Request $request)
{
    // Obtener los parámetros de la URL (veterinarian_id y appointment_date)
    $veterinarianId = $request->query('veterinarian_id');
    $appointmentDate = $request->query('appointment_date');

    // Convertir el appointment_date a un formato de Carbon, si es necesario
    try {
        $appointmentDate = \Carbon\Carbon::parse($appointmentDate);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Fecha de cita inválida.');
    }

    // Buscar el veterinario y la cita en función de los parámetros
    $veterinarian = Veterinarian::find($veterinarianId);
    $appointment = Appointment::where('veterinarian_id', $veterinarianId)
        ->where('appointment_date', $appointmentDate)
        ->first();

    // Si no se encuentra el veterinario o la cita, redirigir con error
    if (!$veterinarian || !$appointment) {
        return redirect()->back()->with('error', 'Cita o veterinario no encontrados.');
    }

    // Retornar la vista 'appointment-manager' con los datos de la cita y veterinario
    return view('appointment-manager', [
        'veterinarian' => $veterinarian,
        'appointment' => $appointment
    ]);
}




    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function downloadPDF($id)
    {
        // Cargar la cita con sus relaciones
        $appointment = Appointment::with('pet', 'veterinarian.user')->findOrFail($id);

        // Cargar la vista para generar el PDF
        $pdf = PDF::loadView('pdf.appointments', compact('appointment'));

        // Descargar el PDF con un nombre dinámico basado en el ID de la cita
        return $pdf->download('appointment-'.$appointment->id.'.pdf');
    }
}
