<?php

namespace App\Http\Controllers\ODP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\Portafolio;   
use App\Models\LinkFirma;
 
class SolicitarFirma extends Controller
{
    public function index(Request $request)  
    {
        $mousePosX = $request->input('mousePosX'); 
        $mousePosY = $request->input('mousePosY'); 
        $Pagina = $request->input('Pagina');  

        $Ancho = $request->input('Ancho'); 
        $Alto = $request->input('Alto'); 

        $rules = [
            'Ancho' => 'required',
        ]; 
     
        $messages = [ 
            'Ancho.required' =>'Por favor seleccione el lugar en donde ira la firma digital.'
        ]; 
    
        $this->validate($request, $rules, $messages);


        $ID_LinkFirma = $request->input('ID_LinkFirma');

        $Observacion = $request->input('ObservacionPortafolio');

        if($Observacion==""){
            $Observacion="1010xq";

        }
 
        $token = md5($mousePosX); 
  
        if(empty($Pagina)){  
            $Pagina = 1; 
        }     
   
        $Contenido='gestiondocumental.test/firmarsolicitud/'.$ID_LinkFirma.'/'.$token.'';
        
        $LinkFirma                   = LinkFirma::find($ID_LinkFirma);  
        $LinkFirma->mousePosX        = $mousePosX; 
        $LinkFirma->mousePosY        = $mousePosY;   
        $LinkFirma->Pagina           = $Pagina; 
        $LinkFirma->Ancho            = $Ancho;   
        $LinkFirma->Alto             = $Alto; 
        $LinkFirma->Token            = $token;   
        $LinkFirma->Observacion      = $Observacion;  
        $LinkFirma->Contenido        = $Contenido;  
        $LinkFirma->Estado           = 1;
        $LinkFirma->save(); 

        $LinkFirma =  DB::table('LinkFirma')
        ->leftjoin('Portafolio', 'LinkFirma.ID_Documento_L', '=', 'Portafolio.ID_Documento_T') 
        ->select('ID_Documento_L') 
        ->where('ID_LinkFirma', '=',  $ID_LinkFirma)->first(); 

        $Portafolio             =Portafolio::find($LinkFirma->ID_Documento_L);
        $Portafolio->Estado_T   = 22;
        $Portafolio->save();

        return view('Posts/ODP/FirmarDocumentosODP'); 
    } 
}
