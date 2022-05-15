<?php

namespace App\Http\Controllers\Solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
 
class PosicionarFirmaController11 extends Controller
{
    public function index(Request $request)
    {
        $ID_Documento_T = $request->input('ID_Documento_T');  
        $ID_LinkFirma = $request->input('ID_LinkFirma');  

        $datos=DB::table('DestinoDocumento11')->Select('Ruta_T')->where('DOC_ID_Documento', '=', $ID_Documento_T)->first();
	   
        $Ruta = $datos->Ruta_T;
 
        session(['Ruta' => $Ruta]);  
        session(['ID_LinkFirma' => $ID_LinkFirma]);  
           
        //return view('Documentos/FirmarDocumento')->with('Ruta', $Ruta); 
        return view('Posts/Solicitudes/SolicitarFirma11'); 
 
    }
}
