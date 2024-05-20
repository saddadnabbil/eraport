<?php

namespace App\Http\Controllers\Guru\MD;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{

    public function viewSilabusPDF($filename)
    {
        $pdfUrl = asset("storage/silabus/{$filename}");
        $title = "Silabus | {$filename}";

        return view('guru.md.silabus.pdf.view', compact('title', 'pdfUrl'));
    }
}
