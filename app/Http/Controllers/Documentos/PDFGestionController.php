<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PDFGestionController extends Controller
{
    public function index(Request $request)  
    {



        $ID_Documento_T  = $request->input('ID_Documento_T');



        $datos=DB::table('Documento')->Select('Ruta_T')->where('ID_Documento_T', '=', $ID_Documento_T)->get();
	   
        foreach ($datos as $Dato){
            $Ruta = $Dato->Ruta_T;
        } 
         
        
    	
		$contents = Storage::disk('PDF')->get($Ruta);
        
			

        header('Content-Type: application/pdf');
	
        header('Content-Disposition: inline; filename="'.basename($Ruta).'"');
        echo $contents;

        dd('buena');
    }
}
