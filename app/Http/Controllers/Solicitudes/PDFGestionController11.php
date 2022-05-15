<?php

namespace App\Http\Controllers\Solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PDFGestionController11 extends Controller
{
    public function index(Request $request)  
    {
        $ID_DestinoDocumento   = $request->input('ID_DestinoDocumento');

        $datos=DB::table('DestinoDocumento11')->Select('Ruta_T')->where('ID_DestinoDocumento', '=', $ID_DestinoDocumento)->get();
	   
        foreach ($datos as $Dato){
            $Ruta = $Dato->Ruta_T;
        } 
    
		$contents = Storage::disk('PDF11')->get($Ruta);
        	
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="'.basename($Ruta).'"');
        echo $contents;

       
    }
}
