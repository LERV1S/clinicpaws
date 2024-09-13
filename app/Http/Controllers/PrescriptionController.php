<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use PDF; // Barryvdh DomPDF
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function downloadPDF($id)
    {
        $prescription = Prescription::with('pet', 'veterinarian.user')->findOrFail($id);

        $pdf = PDF::loadView('pdf.prescriptions', compact('prescription'));
        return $pdf->download('prescription-' . $prescription->id . '.pdf');
    }
}
