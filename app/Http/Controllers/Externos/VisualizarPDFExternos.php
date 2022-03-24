<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisualizarPDFExternos extends Controller
{
    public function index(Request $request)  
    {
        $Ruta   = $request->input('Ruta');

		$contents = Storage::disk('PDF')->get($Ruta);
        	
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="'.basename($Ruta).'"');
        echo $contents;
    }
}
