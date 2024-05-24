<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{

    public function viewSilabusPDF($filename)
    {
        $pdfUrl = asset("storage/silabus/{$filename}");
        $title = "Syllabus | {$filename}";

        return view('admin.silabus.pdf.view', compact('title', 'pdfUrl'));
    }
}
