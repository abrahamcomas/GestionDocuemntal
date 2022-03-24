<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
 
class PosicionFirmaController extends Controller
{ 
    public function FirmaDetenidoIndividual(Request $request)
    {   
        $ID_DestinoDocumento = $request->input('ID_DestinoDocumento');  

        $datos=DB::table('DestinoDocumento')->Select('Ruta_T','DOC_ID_Documento')->where('ID_DestinoDocumento', '=', $ID_DestinoDocumento)->first();
	   
        $Ruta = $datos->Ruta_T; 
        $ID_Documento_T  = $datos->DOC_ID_Documento;

        session(['Ruta' => $Ruta]); 
        session(['ID_Documento_T' => $ID_Documento_T]);  
           
        return view('Posts/Portafolio/FirmaDetenidoIndividual'); 
    }

    public function FirmaDetenidoMasiva(Request $request)
    {   
        $ID_Documento_T = $request->input('ID_Documento_T');  
        
        $Cuantos =  DB::table('DestinoDocumento')->select('ID_DestinoDocumento')->where('DOC_ID_Documento', '=',$ID_Documento_T)->get();

        $cuantos=count($Cuantos);

        $horaInicial = date('h:i');  
        $minutoAnadir=$cuantos*30;
 
        $segundos_horaInicial=strtotime($horaInicial);
        
        $nuevaHora=date("H:i",$segundos_horaInicial+$minutoAnadir); 

        $Documento =  DB::table('Portafolio')
        ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento') 
        ->select('Ruta_T')->where('ID_Documento_T', '=',$ID_Documento_T)->first();
	   
        $Ruta = $Documento->Ruta_T;
 
        session(['Ruta' => $Ruta]);  
           
        return view('Posts/Portafolio/FirmaDetenidoMasiva')->with('cuantos', $cuantos)->with('nuevaHora', $nuevaHora); 
    }
 


    public function FirmaIndRec(Request $request) 
    {    

        $ID_DestinoDocumento = $request->input('ID_DestinoDocumento');  
        $IPF_ID = $request->input('IPF_ID'); 

        $datos=DB::table('DestinoDocumento')->Select('Ruta_T','DOC_ID_Documento')->where('ID_DestinoDocumento', '=', $ID_DestinoDocumento)->first();
	   
        $Ruta = $datos->Ruta_T;
        $ID_Documento_T  = $datos->DOC_ID_Documento;

        session(['Ruta' => $Ruta]);  
        session(['ID_DestinoDocumento' => $ID_DestinoDocumento]);   
        session(['ID_Documento_T' => $ID_Documento_T]);    
        session(['IPF_ID' => $IPF_ID]);    
        //return view('Documentos/FirmarDocumento')->with('Ruta', $Ruta); 
        return view('Posts/Portafolio/FirmaIndRec');  
    } 

    public function FirmaMasivaRec(Request $request)
    {   

        $ID_Documento_T = $request->input('ID_Documento_T');  

        $datos=DB::table('DestinoDocumento')->Select('Ruta_T')->where('DOC_ID_Documento', '=', $ID_Documento_T)->first();
	   
        $Ruta = $datos->Ruta_T;

        session(['Ruta' => $Ruta]); 
        session(['ID_Documento_T' => $ID_Documento_T]);   
           
        //return view('Documentos/FirmarDocumento')->with('Ruta', $Ruta); 
        return view('Posts/Portafolio/FirmaMasivaRec'); 
    }

    public function FirmarIndividualDirecto(Request $request)
    {    

        $ID_DestinoDocumento = $request->input('ID_DestinoDocumento');  

        $datos=DB::table('DestinoDocumento')->Select('Ruta_T')->where('ID_DestinoDocumento', '=', $ID_DestinoDocumento)->first();
	   
        $Ruta = $datos->Ruta_T; 
 
        session(['Ruta' => $Ruta]);   
           
        return view('Posts/EncargadoODP/FirmaIndividual'); 
    }

    public function FirmaMasivaDirecto(Request $request)
    {   

        $ID_Documento_T = $request->input('ID_Documento_T');  

        $datos=DB::table('DestinoDocumento')->Select('Ruta_T')->where('DOC_ID_Documento', '=', $ID_Documento_T)->first();
	   
        $Ruta = $datos->Ruta_T;

        session(['Ruta' => $Ruta]);   
        session(['ID_Documento_T' => $ID_Documento_T]);   
         
        return view('Posts/EncargadoODP/FirmaMasiva'); 
    }

    public function index4(Request $request) 
    {   
        $ID_Documento_T = $request->input('ID_Documento_T');  
        $ID_LinkFirma = $request->input('ID_LinkFirma');  

        $datos=DB::table('DestinoDocumento')->Select('Ruta_T')->where('DOC_ID_Documento', '=', $ID_Documento_T)->first();
	   
        $Ruta = $datos->Ruta_T;
 
        session(['Ruta' => $Ruta]);  
        session(['ID_LinkFirma' => $ID_LinkFirma]);  
           
        //return view('Documentos/FirmarDocumento')->with('Ruta', $Ruta); 
        return view('Posts/ODP/SolicitarFirma'); 
    }

  

   

    public function QR(Request $request) 
    {   
        $ID_DestinoDocumento = $request->input('ID_DestinoDocumento');  

        $datos=DB::table('DestinoDocumento')->Select('Ruta_T')->where('ID_DestinoDocumento', '=', $ID_DestinoDocumento)->first();
	   
        $Ruta = $datos->Ruta_T;
 
        session(['Ruta' => $Ruta]);  

        $NuevaRuta = substr($Ruta, 0, -4);
        $NuevaRuta2 = $NuevaRuta.'.png';

        $contenido='controldeparte.test/MostrarMultaQRMulta/'.$ID_DestinoDocumento.'';

        $qrimage= public_path('../public/QR/'.$NuevaRuta.'.png');
        \QRCode::url($contenido)->setOutfile($qrimage)->png();

        return view('Posts/Portafolio/QR')->with('NuevaRuta2', $NuevaRuta2);
    }
}
 