<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use PDF; // Esto requiere Barryvdh DomPDF
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

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
