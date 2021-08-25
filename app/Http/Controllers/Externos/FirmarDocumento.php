<?php

namespace App\Http\Controllers\Externos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\File;

class FirmarDocumento extends Controller
{
    public function index(Request $request)
    {  

        $rules = [
            'PDF' => 'required', 
            'Contrasenia' => 'required|min:6',
        ];

        $messages = [
            'PDF.required' =>'El campo PDF es obligatorio.',
            'Contrasenia.required' =>'El campo Contraseña es obligatorio.' 
        ];

        $this->validate($request, $rules, $messages);


        
        $PDF = $request->file('PDF'); 
        $Contrasenia = $request->input('Contrasenia'); 
        $RUNInspector=Auth::guard('web')->user()->Rut;
        $RutFirma = substr($RUNInspector, 0, -2); 


        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $Contrasenia], true))
        { 



        
            $hoy = date("Y-m-d H:i:s");   
            $NuevaFecha = strtotime ( '-4 hours, +4 minute' , strtotime ($hoy) ) ; 
            $NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
    
            $header   = [                
                "alg"=> "HS256",
                "typ"=> "JWT"         
            ];
    
            $payload  = [               
                "entity" => "Ilustre Municipalidad de Curicó",
                "run" => $RutFirma,
                "expiration" => $NuevaFecha,
                "purpose" => "Desatendido"         
            ];
    
            $key = "e2c0c1c5115e4d11ad29ff6ff5510c9e";
            $header2 = base64_Encode(json_encode($header, JSON_UNESCAPED_UNICODE));
            
            $payload2 = base64_Encode(json_encode($payload, JSON_UNESCAPED_UNICODE));
            $payload2 =str_replace("=","",$payload2);
            
            $unsignedToken = $header2.'.'.$payload2;
    
            $signature = hash_hmac('sha256',$unsignedToken,$key,true);
            $signature = base64_Encode($signature);
           
            $token = $unsignedToken.'.'.$signature;
            $OTP = $request->input('OTP');     
    
            
            
            
            
            
            
            
        
    
    
    
           
            $file = $request->file('PDF')->getClientOriginalName();
    
            $NombreArchivo =basename($request->file('PDF')->getClientOriginalName(),'.'.$request->file('PDF')->getClientOriginalExtension());
            
            $Extencion =$request->file('PDF')->getClientOriginalExtension();
           
       
     
         
    
            $contenidoBinario = file_get_contents($PDF);
            
            $codificado = base64_encode($contenidoBinario);
    
            $Sha256 = hash('sha256', $PDF);
    
            $rutaImagen = "Imagenes/escudo.png";
    $contenidoBinario = file_get_contents($rutaImagen);
    $imagenComoBase64 = base64_encode($contenidoBinario);
    
    
                $response = Http::post('https://api.firma.cert.digital.gob.cl/firma/v2/files/tickets',[
                    "api_token_key"=> "b6c89848-d732-4cf0-9d5c-771cd7a38e01",
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
                                                <Visible active=\"true\" layer2=\"true\" label=\"true\" pos=\"1\">
                                                        <llx>0</llx>
                                                        <lly>40</lly>
                                                        <urx>600</urx>
                                                        <ury>10</ury> 
                                                        <page>LAST</page> 
                                                        <image>BASE64</image> 
                                                        <BASE64VALUE>$imagenComoBase64</BASE64VALUE>
                                                    </Visible> 
                                                </Signature> 
                                            </Application> 
                                        </AgileSignerConfig>"
                                        
                    ])
            ]);
        
             $responseBody = json_decode($response->getBody());

             dd( $responseBody);
        
        if(empty($responseBody->status))
            { 
                $responseFiles = $responseBody->files;
                foreach($responseFiles as $posicion)
                    { 
                         $status = $posicion->status;
                    }
                         
                if($status=='OK')
                    {  

                        foreach($responseFiles as $posicion)
                        {
                            $content = $posicion->content;
                            $status = $posicion->status;
                            $checksum_original = $posicion->checksum_original;
                        }
                     
                        $hoy = date("Y-m-d");   
                        $decoded = base64_decode($content);
                        $file = $checksum_original.'Firmado'.'.'.$NombreArchivo.'.'.$hoy.'.'.$Extencion;
                        $sube = file_put_contents($file, $decoded);
            
                        $image = $request->get('image_base64');  // your base64 encoded
                        $image = str_replace('data:pdf;base64,', '', $decoded);
                        $image = str_replace(' ', '+', $image);
                       
                        if (file_exists($file)) {
                            header("Content-Description: File Transfer");
                            header("Content-Type: application/octet-stream");
                            header('Content-Disposition: attachment; filename="'.basename($file).'"');
                            header("Expires: 0");
                            header("Cache-Control: must-revalidate");
                            header("Pragma: public");
                            header("Content-Length: " . filesize($file));
                            $guardar= readfile($file);
                    
                            exit; 
                        }

                         return view('DocumentoExt/Respuesta', compact('status'));
                     
                    }
                else 
                    {
                        return view('DocumentoExt/Respuesta', compact('status'));
                    }

            }
        else{
                 $status='ERROR, firma digital no registrada';
                 return view('DocumentoExt/Respuesta', compact('status'));

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
