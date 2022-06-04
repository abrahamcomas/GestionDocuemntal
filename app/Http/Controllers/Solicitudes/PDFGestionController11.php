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
        $ID_Documento_T   = $request->input('ID_Documento_T');
        $ID_Funcionario_T = $request->input('ID_Funcionario_T');  

        $MostrarDocumentos =  DB::table('DestinoDocumento11') 
        ->leftjoin('DocumentoFirma11', 'DestinoDocumento11.ID_DestinoDocumento', '=', 'DocumentoFirma11.ID_Documento')
        ->select('Ruta_T')
        ->where('DOC_ID_Documento', '=',$ID_Documento_T)
        ->where('ID_Funcionario', '=',$ID_Funcionario_T)->first();

        session(['Ruta_T' => $MostrarDocumentos->Ruta_T]);  

        return view('Posts/Solicitudes/VerPDF11'); 
       
    }
 

    public function PDFExterno(Request $request)  
    { 
        $ID_DestinoDocumento   = $request->input('ID_DestinoDocumento');

        $MostrarDocumentos =  DB::table('DestinoDocumento11') 
        ->select('Ruta_T')
        ->where('ID_DestinoDocumento', '=',$ID_DestinoDocumento)->first(); 

        $contents = Storage::disk('PDF')->get($MostrarDocumentos->Ruta_T);
        	
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="'.basename($MostrarDocumentos->Ruta_T).'"');
        echo $contents;


 
    }
}
 