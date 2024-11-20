<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use PDF; // Alias de Barryvdh\DomPDF\Facade
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Client;
use App\Models\Inventory;
use Dompdf\Dompdf;
use Dompdf\Options;
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
        // Encuentra el ticket por su ID con las relaciones necesarias
        $ticket = Ticket::with('client.user', 'inventories')->findOrFail($id);

        // Crear una instancia de Dompdf con opciones
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Crear la instancia de Dompdf
        $dompdf = new Dompdf($options);

        // Renderizar la vista en HTML
        $html = view('pdf.tickets', compact('ticket'))->render();

        // Cargar el contenido HTML en Dompdf
        $dompdf->loadHtml($html);

        // Definir el tamaño del papel y la orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Obtener el canvas de Dompdf
        $canvas = $dompdf->getCanvas();

        // Ruta de la imagen de la marca de agua
        $imagePath = public_path('images/Clinic_Paws2.png');

        // Aplicar la marca de agua en todas las páginas
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas) use ($imagePath) {
            $canvas->image($imagePath, 100, 200, 400, 400); // Ajusta el tamaño y la posición
        });

        // Descargar el PDF
        return $dompdf->stream('ticket_' . $ticket->id . '.pdf', ['Attachment' => false]);
    }

}
