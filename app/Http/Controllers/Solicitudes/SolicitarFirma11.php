<?php

namespace App\Http\Controllers\Solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use App\Models\Portafolio11;   
use App\Models\LinkFirma11;

class SolicitarFirma11 extends Controller
{
    public function index(Request $request)  
    {

        $ID_Documento_T = $request->input('ID_Documento_T');  
        $ID_LinkFirma = $request->input('ID_LinkFirma');  


        $mousePosX = 35; 
        $mousePosY = 465; 
        $Pagina = 1;    

        $Ancho = 609; 
        $Alto = 793; 

        $Observacion = $request->input('ObservacionPortafolio');

        if($Observacion==""){
            $Observacion="1010xq";

        }
 
        $token = md5($mousePosX);   
  
        if(empty($Pagina)){   
            $Pagina = 1;
        }     
   
        $Contenido='gestiondocumental.test/firmarsolicitud11/'.$ID_LinkFirma.'/'.$token.'';
        
        $LinkFirma11                   = LinkFirma11::find($ID_LinkFirma);  
        $LinkFirma11->mousePosX        = $mousePosX; 
        $LinkFirma11->mousePosY        = $mousePosY;   
        $LinkFirma11->Pagina           = $Pagina; 
        $LinkFirma11->Ancho            = $Ancho;   
        $LinkFirma11->Alto             = $Alto; 
        $LinkFirma11->Token            = $token;   
        $LinkFirma11->Contenido        = $Contenido;  
        $LinkFirma11->Estado           = 1;
        $LinkFirma11->save(); 

        return view('Posts/Solicitudes/Solicitudes'); 
    } 
}
