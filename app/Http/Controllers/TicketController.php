<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use PDF; // Alias de Barryvdh\DomPDF\Facade
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Client;
use App\Models\Inventory;
class TicketController extends Controller
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
        // Encuentra el ticket por su ID
        $ticket = Ticket::with('client.user')->findOrFail($id);

        // Carga la vista y pasa los datos del ticket
        $pdf = PDF::loadView('pdf.tickets', compact('ticket'));

        // Devuelve el PDF para descargar
        return $pdf->download('ticket_' . $ticket->id . '.pdf');
    }

}
