<?php

namespace App\Http\Controllers\Solicitudes;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class FirmarSolicitudEmisor extends Controller
{
    public function index(Request $request)
    {   
        $ID_Documento_T = $request->input('ID_Documento_T'); 
        
        $datos=DB::table('DestinoDocumento11')->Select('Ruta_T','DOC_ID_Documento')->where('DOC_ID_Documento', '=', $ID_Documento_T)->first();
	   
        $Ruta = $datos->Ruta_T; 
        $ID_Documento_T  = $datos->DOC_ID_Documento;
 
        session(['Ruta' => $Ruta]); 
        session(['ID_Documento_T' => $ID_Documento_T]);  
           
        return view('Posts/Solicitudes/Firmar'); 
    } 

}
 