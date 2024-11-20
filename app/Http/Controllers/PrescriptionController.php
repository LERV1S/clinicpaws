<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use PDF; // Barryvdh DomPDF
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;


class PrescriptionController extends Controller
{
    public function downloadPDF($id)
    {
        // Encuentra la prescripción por su ID con las relaciones necesarias
        $prescription = Prescription::with('pet', 'veterinarian.user')->findOrFail($id);

        // Crear una instancia de Dompdf con opciones
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Crear la instancia de Dompdf
        $dompdf = new Dompdf($options);

        // Renderizar la vista en HTML
        $html = view('pdf.prescriptions', compact('prescription'))->render();

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
        return $dompdf->stream('prescription_' . $prescription->id . '.pdf', ['Attachment' => false]);
    }
}
