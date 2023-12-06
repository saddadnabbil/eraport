<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function downloadSilabus($file)
    {
        $filePath = storage_path('app/public/silabus/' . $file);

        if (file_exists($filePath)) {
            return Storage::download('public/silabus/' . $file);
        } else {
            abort(404);
        }
    }
}
