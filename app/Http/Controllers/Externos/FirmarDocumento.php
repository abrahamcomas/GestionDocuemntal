<?php
 
namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\DocumentosExterno; 
use App\Models\DocumentosZip;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use JWTAuth; 
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\File;
use App\Models\solofirma;
use Response;
use Illuminate\Support\Facades\DB;  
use ZipArchive;

class FirmarDocumento extends Controller
{
    public function index(Request $request) 
    {  
        $Ruta  = $request->input('Ruta');

        $NombreZip =DB::table('DocumentosExterno')->Select('NombreZip')->where('Ruta_T', '=', $Ruta)->first();

        $NombreZip = $NombreZip->NombreZip;
       
        $Archivos =  DB::table('DocumentosExterno') 
        ->select('Ruta_T')
        ->where('NombreZip', '=',$NombreZip )
        ->get();

        foreach ($Archivos as $Ruta_T) {  

            $Contrasenia = $request->input('Contrasenia'); 
            $mousePosX = $request->input('mousePosX'); 
            $mousePosY = $request->input('mousePosY'); 
            $Pagina = $request->input('Pagina'); 

            $Ancho = $request->input('Ancho'); 
            $Alto = $request->input('Alto'); 

            if(empty($Pagina)){
                $Pagina = 1;
            } 

            $rules = [
                'Contrasenia' => 'required',
                'Ancho' => 'required',
            ]; 
        
            $messages = [ 
                'Contrasenia.required' =>'El campo Contraseña es obligatorio.',
                'Ancho.required' =>'Por favor seleccione el lugar en donde ira la firma digital.'
            ]; 
    
            $this->validate($request, $rules, $messages);

            $RUNInspector=Auth::guard('web')->user()->Rut;
            $RutFirma = substr($RUNInspector, 0, -2); 

            if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $Contrasenia], true))
            { 

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
            
            
                $datos=DB::table('DocumentosExterno')->Select('Ruta_T')->where('Ruta_T', '=', $Ruta)->first();
                                            
                $Ruta = $Ruta_T->Ruta_T; 
                                                
                $PDF = Storage::disk('PDF')->get($Ruta); 

                $codificado = base64_encode($PDF); 
            
                $Sha256 = hash('sha256', $PDF);

                $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;   
                $rutaImagen=DB::table('ImagenFirma')->Select('Ruta')->where('id_Funcionario_T', '=', $ID_Funcionario)->first();
                $rutaImagen2="Firmas/".$rutaImagen->Ruta;

                $contenidoBinario = file_get_contents($rutaImagen2);
                $imagenComoBase64 = base64_encode($contenidoBinario);
            
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
                                            <page>$Pagina</page> 
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
        
                                $hoy = date("Y-m-d");   
                                $decoded = base64_decode($content);
                                $image = $request->get('image_base64');  // your base64 encoded
                                $image = str_replace('data:pdf;base64,', '', $decoded);
                                $image = str_replace(' ', '+', $image);
                                
                                Storage::disk('PDF')->put($Ruta, $decoded);        
                        
                   
        

                           

                            $ID   =  DB::table('DocumentosExterno')->where('Ruta_T', '=',$Ruta)->first();
                            
                            $NombreDocumento = substr($ID->NombreDocumento, 0, -4); 

                            $Fecha = date("Y/m/d"); 
 
                            $Hora = date("h:i:s");  
                    
                            $numeroDiaFC = date('d', strtotime($Fecha));
                            $mesFC = date('F', strtotime($Fecha));
                    
                            if($mesFC=='January'){
                                $mesFC= 'Enero';
                                }
                                elseif($mesFC=='February'){   
                                $mesFC= 'Febrero';
                                }
                                elseif($mesFC=='March'){  
                                $mesFC= 'Marzo';
                                }
                                elseif($mesFC=='April'){
                                    $mesFC= 'Abril';
                                }
                                elseif($mesFC=='May'){
                                    $mesFC= 'Mayo';
                                }
                                elseif($mesFC=='June'){
                                    $mesFC= 'Junio';
                                }
                                elseif($mesFC=='July'){ 
                                    $mesFC= 'Julio';
                                }
                                elseif($mesFC=='August'){  
                                    $mesFC= 'Agosto';
                                }
                                elseif($mesFC=='September'){  
                                    $mesFC= 'Septiembre';
                                }
                                elseif($mesFC=='October'){  
                                    $mesFC= 'Octubre';
                                }
                                elseif($mesFC=='November'){  
                                    $mesFC= 'Noviembre';
                                }
                                else{  
                                    $mesFC= 'Diciembre';
                            }
                            
                            $Datos='Firmado el '.$numeroDiaFC.' de '.$mesFC.'.pdf';
                            
                            $NombreFinal =  $NombreDocumento.' '.$Datos;

                            $DocumentoFirma             =DocumentosExterno::find($ID->ID);
                            $DocumentoFirma->Firmado    = 1;
                            $DocumentoFirma->NombreDocumento    = $NombreFinal;
                            $DocumentoFirma->save();
                                
                        } 
                        else 
                        {
                            
                        }

                    } 
                    else  
                    {
                        $status='Error en conexión con el servidor de destino.';
                  
                    }

                }
                else{
                    $status='ERROR, firma digital no registrada';
          

                }                            
            }                                
            else
            {
                return back()
                ->withErrors(['Contraseña Incorrecta'])
                ->withInput(request(['RUN'])); 
            }
        }
        //END FOREACH

        $zip = new ZipArchive();
  
        $nombreArchivo   =  DB::table('DocumentosExterno')->select('NombreZip')->where('Ruta_T', '=',$Ruta)->first();
        $nombreArchivo=$nombreArchivo->NombreZip.'.zip';

        $nombreArchivoZip = "../public/ZIP/".$nombreArchivo;
                            
        if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            exit("Error abriendo ZIP en $nombreArchivoZip");
        }

        $Archivos =  DB::table('DocumentosExterno') 
        ->select('NombreDocumento','Ruta_T')
        ->where('NombreZip', '=',$NombreZip )
        ->get();

    
        foreach ($Archivos as $Ruta_T) {  
           
            $nombre = $Ruta_T->NombreDocumento;
            $zip->addFile('../public/PDF/'.$Ruta_T->Ruta_T, $nombre);

        } 
                                
        $resultado = $zip->close(); 
        if (!$resultado) {
            exit("Error creando archivo");
        } 
              
        $DIA=date("d");

        $DocumentosZip                  = new DocumentosZip;
        $DocumentosZip->id_Funcionario  = Auth::user()->ID_Funcionario_T;
        $DocumentosZip->NombreDocumento = $nombreArchivo;  
        $DocumentosZip->Ruta_T          = $token;   
        $DocumentosZip->DIA             = $DIA;
        $DocumentosZip->save();  

     
        return view('DocumentosExt/Respuesta')->with('status', $status)->with('nombreArchivo', $nombreArchivo);
    }
}
