<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Http;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;

use App\Models\DocFunc;
use App\Models\DocumentoFirma;

class FirmarDocumentoController extends Controller
{
    public function index(Request $request)   
    {

        $TipoFirma=Auth::guard('web')->user()->TipoFirma;
       
        
        if($TipoFirma=='1'){
                
            $rules = [
                'OTP' => 'required',
                'Contrasenia' => 'required',
            ]; 
     
            $messages = [ 
                'OTP.required' =>'El campo OTP es obligatorio.',
                'Contrasenia.required' =>'El campo Contraseña es obligatorio.',  
            ]; 
    
            $this->validate($request, $rules, $messages);
        }
        else{

            $rules = [
                'Contrasenia' => 'required',
            ]; 
     
            $messages = [ 
                'Contrasenia.required' =>'El campo Contraseña es obligatorio.',
            ]; 
    
            $this->validate($request, $rules, $messages);

        }

        $ID_Documento_T  = $request->input('ID_Documento_T');
        $Contrasenia = $request->input('Contrasenia'); 
        $OTP = $request->input('OTP'); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        $RutFirma = substr($RUNInspector, 0, -2); 


        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $Contrasenia], true))
        { 

            $datos=DB::table('Documento')->Select('Ruta_T')->where('ID_Documento_T', '=', $ID_Documento_T)->get();
                                        
            foreach ($datos as $Dato){
                $Ruta = $Dato->Ruta_T;
            } 
                                            
            $PDF = Storage::disk('PDF')->get($Ruta); 

            $hoy = date("Y-m-d H:i:s");   
            $NuevaFecha = strtotime ( '+4 minute' , strtotime ($hoy) ) ; 
            $NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 

            if($TipoFirma=='1')
            { 
                $Purpose='Propósito General';    
                $header= [      
                                "alg"=> "HS256",
                                "typ"=> "JWT",
                                "OTP"=> $OTP
                    ];
            }
            else
            {
                $Purpose='Desatendido';    
                $header   = [      
                                "alg"=> "HS256",
                                "typ"=> "JWT"
                    ];
            }

            $header2 = base64_Encode(json_encode($header, JSON_UNESCAPED_UNICODE));
                    
            $payload  = [               
                        "entity" => "Ilustre Municipalidad de Curicó",
                        "run" =>  '17486231',
                        "expiration" => $NuevaFecha,
                        "purpose" =>  $Purpose
            ];

            $key = "e2c0c1c5115e4d11ad29ff6ff5510c9e";
            $header2 = base64_Encode(json_encode($header, JSON_UNESCAPED_UNICODE));
            
            $payload2 = base64_Encode(json_encode($payload, JSON_UNESCAPED_UNICODE));
            $payload2 =str_replace("=","",$payload2);
            
            $unsignedToken = $header2.'.'.$payload2;

            $signature = hash_hmac('sha256',$unsignedToken,$key,true);
            $signature = base64_Encode($signature); 
        
            $token = $unsignedToken.'.'.$signature;                              
                                        
            $codificado = base64_encode($PDF);
        
            $Sha256 = hash('sha256', $PDF);

            $response = Http::post('https://api.firma.cert.digital.gob.cl/firma/v2/files/tickets',[
                    "api_token_key"=> "b6c89848-d732-4cf0-9d5c-771cd7a38e01",
                    "token"=> $token,
                    "files"=> array([
                            "content-type"=> "application/pdf",
                            "content"=>  $codificado,
                            "description"=> "str",
                            "checksum"=> $Sha256
                            
                                        
                    ])
            ]);
                                        
            $responseBody = json_decode($response->getBody());


            if(empty($responseBody->status))
                { 
                    
                    if($responseFiles = $responseBody->files!=null)

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
                                
                                    if (file_exists($Ruta)) {
                                        header("Content-Description: File Transfer");
                                        header("Content-Type: application/octet-stream");
                                        header('Content-Disposition: attachment; filename="'.basename($Ruta).'"');
                                        header("Expires: 0");
                                        header("Cache-Control: must-revalidate");
                                        header("Pragma: public");
                                        header("Content-Length: " . filesize($Ruta));
                                        $guardar= readfile($Ruta);
                                        exit;
                                    }

                    

                                    $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

                            
        

                                    $Buscar_ID_IntDocFunc  =  DB::table('DocumentoFirma')
                                    ->where('ID_Documento', '=',$ID_Documento_T)
                                    ->where('ID_Funcionario', '=',$ID_Funcionario)->get();
            
                                    foreach ($Buscar_ID_IntDocFunc as $user){
                                        $ID_DocumentoFirma   = $user->ID_DocumentoFirma;
            
                                        }
            
            
                                    $DocumentoFirma             =DocumentoFirma::find($ID_DocumentoFirma);
                                    $DocumentoFirma->FechaFirma = date("Y/m/d");
                                    $DocumentoFirma->Firmado    = 1;
                                    $DocumentoFirma->save(); 

                                    return view('Documentos/DocumentoFirmado', compact('status'));
                                
                                }
                                else 
                                {
                                    return view('Documentos/DocumentoFirmado', compact('status'));
                                }

                                 }
                            else 
                                {
                                    $status='ERROR, firma digital';
                                    return view('Documentos/DocumentoFirmado', compact('status'));
                                }

                }
                else{
                    $status='ERROR, firma digital no registrada';
                    return view('Documentos/DocumentoFirmado', compact('status'));

                }                            
        }                                
        else
        {
            return back()
            ->withErrors(['Contraseña Incorrecta'])
            ->withInput(request(['RUN'])); 
        }
    }
}
