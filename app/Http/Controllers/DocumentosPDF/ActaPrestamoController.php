<?php

namespace App\Http\Controllers\DocumentosPDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage; 

use App\Models\Portafolio11;
use App\Models\DocumentoFirma11;
use App\Models\DestinoDocumento11;
use App\Models\LinkFirma11;
use App\Models\InterPortaFuncionario; 
use setasign\Fpdi\Fpdi;

class ActaPrestamoController extends Controller
{
    public function index(Request $request)   
    {  

        $SelecID_Funcionario_T  = $request->input('SelecID_Funcionario_T');
        $Materia  = $request->input('Materia');
        $Titulo_T  = $request->input('Titulo_T');
        $Acta  = $request->input('Acta');

        $Equipo1  = $request->input('Equipo1'); 
        $Equipo2  = $request->input('Equipo2'); 
        $Equipo3  = $request->input('Equipo3');
        $Equipo4  = $request->input('Equipo4');
        $Equipo5  = $request->input('Equipo5');
        $Equipo6  = $request->input('Equipo6');
        $Equipo7  = $request->input('Equipo7');
        $Equipo8  = $request->input('Equipo8');

        $Correo1  = $request->input('Correo1'); 
        $Correo2  = $request->input('Correo2');
        $Correo3  = $request->input('Correo3');
        $Correo4  = $request->input('Correo4');
        $Correo5  = $request->input('Correo5');
        $Correo6  = $request->input('Correo6');
        $Correo7  = $request->input('Correo7');
        $Correo8  = $request->input('Correo8'); 

        $rules = [
            'SelecID_Funcionario_T' => 'required',
            'Titulo_T' => 'required',
            'Acta' => 'required',
            'Equipo1' => 'required',
        ]; 
     
        $messages = [ 
            'SelecID_Funcionario_T.required' =>'El campo "Funcionario" es obligatorio.',
            'Titulo_T.required' =>'El campo "Título" es obligatorio.',
            'Acta.required' =>'El campo "Acta" es obligatorio.',
            'Acta.Equipo1' =>'El campo "Equipo 1" es obligatorio.'
        ]; 

        $this->validate($request, $rules, $messages);

        $Funcionario  =  Auth::user()->ID_Funcionario_T;

        $Emisor =  DB::table('Funcionarios') 
        ->select('Nombres','Apellidos')
        ->where('ID_Funcionario_T', '=',$Funcionario)
        ->first(); 

        $NombreEmisor = $Emisor->Nombres;
        $ApellidosEmisor = $Emisor->Apellidos;

            $RUNInspector=Auth::guard('web')->user()->Rut;
            $RutFirma = substr($RUNInspector, 0, -2); 
      
            $Id_Inspector =Auth::guard('web')->user()->id_inspector;
    
            $Id_Multas = $request->input('Id_Multas');
    
            $hoy = date("Y-m-d H:i:s");   
            $NuevaFecha = strtotime ( '+4 minute' , strtotime ($hoy) ) ; 
            $NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
        
                $Purpose='Desatendido';    
                $header   = [      
                                "alg"=> "HS256",
                                "typ"=> "JWT"
                    ];
        
            $header2 = base64_Encode(json_encode($header, JSON_UNESCAPED_UNICODE));
                    
            $payload  = [               
                        "entity" => "Ilustre Municipalidad de Curicó",
                        "run" =>  $RutFirma,
                        "expiration" => $NuevaFecha, 
                        "purpose" =>  $Purpose
            ];

            $key = "2de50761dde340d383f61bf842646352";
            $header2 = base64_Encode(json_encode($header, JSON_UNESCAPED_UNICODE));
            
            $payload2 = base64_Encode(json_encode($payload, JSON_UNESCAPED_UNICODE));
            $payload2 =str_replace("=","",$payload2);
            
            $unsignedToken = $header2.'.'.$payload2;

            $signature = hash_hmac('sha256',$unsignedToken,$key,true);
            $signature = base64_Encode($signature); 
        
            $token = $unsignedToken.'.'.$signature;  
                            
            $PDF = \PDF::loadView('PDF/ActaEntrega/Prestamo', compact('SelecID_Funcionario_T','Materia','Titulo_T','Acta','Equipo1','Equipo2','Equipo3','Equipo4','Equipo5','Equipo6','Equipo7','Equipo8',
            'Correo1','Correo2','Correo3','Correo4','Correo5','Correo6','Correo7','Correo8','NombreEmisor','ApellidosEmisor'));
            $PDF2 = $PDF->output();
                
            $codificado = base64_encode($PDF2);
            $Sha256 = hash('sha256', $PDF2);

            $rutaImagen=DB::table('ImagenFirma')->Select('Ruta')->where('id_Funcionario_T', '=', $Funcionario)->first();
            $rutaImagen2="Firmas/".$rutaImagen->Ruta;
    
            $contenidoBinario = file_get_contents($rutaImagen2);
            $imagenComoBase64 = base64_encode($contenidoBinario);

            $mousePosX = 348; 
            $mousePosY = 465; 
            $Ancho = 595; 
            $Alto = 841; 
            
            $AnchoFirma=(($Ancho*30)/100);
            $AltoFirma=(($Alto*20)/100);
    
            $llx1 = (($mousePosX*100)/$Ancho);
            $lly1 = 100 - (($mousePosY*100)/$Alto);
            $llx = (($llx1*$Ancho)/100) +  $AnchoFirma;  
            $lly = ((($lly1)*$Alto)/100);
            
            $urx = $llx - $AnchoFirma;  
            $ury = $lly - $AltoFirma; 

            $response = Http::post('https://api.firma.digital.gob.cl/firma/v2/files/tickets',[
                "api_token_key"=> "54740e7d-10ac-4b8e-8caa-6c87857b776e",
                    "token"=> $token,
                    "files"=> array([
                        "content-type"=> "application/pdf",
                        "content"=>  $codificado,
                        "description"=> "str",
                        "checksum"=> $Sha256,
                        "layout"=> "<AgileSignerConfig> 
                        <Application id=\"THIS-CONFIG\"> 
                            <pdfPassword/> 
                            <Signature> 
                                <Visible active=\"true\" layer2=\"false\" label=\"false\" pos=\"1\">
                                        <llx>$llx</llx>
                                        <lly>$lly</lly>
                                        <urx>$urx</urx>
                                        <ury>$ury</ury> 
                                        <page>1</page> 
                                        <image>BASE64</image> 
                                        <BASE64VALUE>$imagenComoBase64</BASE64VALUE>
                                </Visible> 
                            </Signature> 
                        </Application> 
                    </AgileSignerConfig>"     
                                        
                    ])        
            ]);
                      
            $responseBody = json_decode($response->getBody());

                if(empty($responseBody->status))
                    { 
                        if(!empty($responseBody->files))
                        { 
                            $responseFiles = $responseBody->files;
                            foreach($responseFiles as $posicion)
                                { 
                                    $status = $posicion->status;
                                }
                                    
                            if($status=='OK')
                            {
                                $responseFiles = $responseBody->files;

                                $responseidSolicitud = $responseBody->idSolicitud;
                                foreach($responseFiles as $posicion)
                                { 
                                    $content = $posicion->content; 
                                    $status = $posicion->status;
                                    $checksum_original = $posicion->checksum_original;
                                }
                                
                                $Portafolio11                    = new Portafolio11;
                                $Portafolio11->ID_Funcionario_Sol= $Funcionario;
                                $Portafolio11->Estado_T          = 1;
                                $Portafolio11->Titulo_T          = $Titulo_T;
                                $Portafolio11->Fecha_T           = date("Y/m/d"); 
                                $Portafolio11->Anio              = date("y"); 
                                $Portafolio11->save();  
                               
                                $Datos  =  DB::table('Funcionarios') 
                                ->select('ID_Funcionario_T','Nombres','Apellidos','Email')
                                ->where('ID_Funcionario_T', '=',$SelecID_Funcionario_T)
                                ->first();
                        
                                $LinkFirma11                   = new LinkFirma11;
                                $LinkFirma11->ID_Documento_L   = $Portafolio11->ID_Documento_T; 
                                $LinkFirma11->Titulo_T         = $Titulo_T; 
                                $LinkFirma11->ID_Funcionario_L = $SelecID_Funcionario_T;   
                                $LinkFirma11->Nombres_L        = $Datos->Nombres; 
                                $LinkFirma11->Apellidos_L      = $Datos->Apellidos; 
                                $LinkFirma11->Estado           = 0;
                                $LinkFirma11->Email            = 0;
                                $LinkFirma11->direccionEmail   = $Datos->Email; 
                                $LinkFirma11->save();
                            
                                $ID_Documento_T  = $Portafolio11->ID_Documento_T;     
                             
                                $hoy = date("Y-m-d");   
                                $decoded = base64_decode($content);
                                $image = $request->get('image_base64');  // your base64 encoded
                                $image = str_replace('data:pdf;base64,', '', $decoded);
                                $image = str_replace(' ', '+', $image);
                                
                                $file = $checksum_original.'.'.'pdf';

                                $codificado = Storage::disk('PDF')->put($file, $decoded);  

                                //CREAR IMAGEN DE PDF
                                $mousePosXF = number_format(($mousePosX*100)/$Ancho);
                                $mousePosXF2 = number_format(($mousePosXF*215)/100);
                                
                                $mousePosYF = number_format(($mousePosY*100)/$Alto);
                                $mousePosYF2 = number_format(($mousePosYF*280)/100);
                                $Pagina=1;

                                $pdf = new FPDI(); 
                                $pagecount =  $pdf->setSourceFile('PDF'.'/'.$file);
                                for($i =1; $i<=$pagecount; $i++){
                            
                                    if($i!=$Pagina){
                                        $pdf->AddPage();
                                        $pdf->setSourceFile('PDF'.'/'.$file);
                                        $template = $pdf->importPage($i);
                                        $pdf->useTemplate($template,0, 0, 215, 280, true);
                                    }
                                    else{ 
                                        
                                        $pdf->AddPage();
                                        $pdf->setSourceFile('PDF'.'/'.$file);   
                                        $template = $pdf->importPage($i);
                                        $pdf->useTemplate($template,0, 0, 215, 280, true);
                                        $pdf->Image('FirmaGeneral/Firma.JPG', $mousePosXF2, $mousePosYF2, 68, 54);
                                    }
                                }

                                $pdf->Output('F', 'ImagenPDF/'.$file);
                                //FIN CREAR IMAGEN DE PDF

                                $token = md5($file);
                        
                                $DestinoDocumento11                   = new DestinoDocumento11;
                                $DestinoDocumento11->ID_FSube         = $Funcionario;
                                $DestinoDocumento11->DOC_ID_Documento = $ID_Documento_T;
                                $DestinoDocumento11->Token            = $token; 
                                $DestinoDocumento11->NombreDocumento  = 'Prestamo'; 
                                $DestinoDocumento11->Ruta_T           = $file;    
                                $DestinoDocumento11->save(); 
                        
                                $DocumentoFirma11                  = new DocumentoFirma11;
                                $DocumentoFirma11->ID_Funcionario  = $Funcionario;
                                $DocumentoFirma11->ID_Documento    = $DestinoDocumento11->ID_DestinoDocumento;  
                                $DocumentoFirma11->Firmado         = 0;  
                                $DocumentoFirma11->save();

                                $DocumentoFirma112                  = new DocumentoFirma11;
                                $DocumentoFirma112->ID_Funcionario  = $SelecID_Funcionario_T;
                                $DocumentoFirma112->ID_Documento    = $DestinoDocumento11->ID_DestinoDocumento;  
                                $DocumentoFirma112->Firmado         = 0;  
                                $DocumentoFirma112->save();
            
                                return view('Posts/Solicitudes/Solicitudes');
                            }
                            else 
                            {
                                return view('FirmarDocumento/ResultadoFirma', compact('status'));
                            }
    
                        }
                        else{
                            $status='ERROR, firma digital no registrada';
                            return view('FirmarDocumento/ResultadoFirma', compact('status'));
    
                        }
            
              
        
           
                    }   
 
    }
}
