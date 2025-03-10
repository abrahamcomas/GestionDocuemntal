<?php

namespace App\Http\Controllers\ODP;

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
use App\Models\Portafolio;
use App\Models\InterPortaFuncionario; 
use App\Models\LinkFirma;
use App\Models\FirmadosDD;
use App\Models\FirmadosFunc;
use App\Models\AnioDD;
use setasign\Fpdi\Fpdi;

use Session;


class FirmandoSolicitudController extends Controller
{
    public function index(Request $request)   
    {  

        $ID_LinkFirma = $request->input('ID_LinkFirma'); 

        $Numero =  DB::table('LinkFirma') 
        ->select('ID_Documento_L')
        ->where('ID_LinkFirma', '=',$ID_LinkFirma)
        ->where('Estado', '=',1)
        ->count();

        if($Numero==1){
                    $ID_Funcionario = $request->input('ID_Funcionario_T'); 
                    $Contrasenia = $request->input('Contrasenia'); 
                    $mousePosX = $request->input('mousePosX'); 
                    $mousePosY = $request->input('mousePosY'); 
                    $Pagina = $request->input('Pagina'); 
                    $Ancho = $request->input('Ancho'); 
                    $Alto = $request->input('Alto'); 

                    $LinkFirma =  DB::table('LinkFirma') 
                    ->select('ID_Documento_L')
                    ->where('ID_LinkFirma', '=',$ID_LinkFirma)
                    ->first();
                
                    $ID_OficinaPartes =  DB::table('DestinoDocumento') 
                    ->select('Ruta_T')
                    ->where('DOC_ID_Documento', '=',$LinkFirma->ID_Documento_L)
                    ->get();

                    $ID_DocumentoFirma  =  DB::table('Funcionarios') 
                        ->select('password')
                        ->where('ID_Funcionario_T', '=',$ID_Funcionario)
                        ->first();

                    if (password_verify($Contrasenia, $ID_DocumentoFirma->password)){
                        
                        foreach ($ID_OficinaPartes as $Ruta_T){  
                
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


                            $DatosFuncionarios =  DB::table('Funcionarios') 
                            ->select('Rut')
                            ->where('ID_Funcionario_T', '=',$ID_Funcionario)
                            ->first();

                            $RUN = $DatosFuncionarios->Rut;
                            $RutFirma = substr($RUN, 0, -2); 
                    
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
                                                    
                            $Ruta = $Ruta_T->Ruta_T;

                            $PDF = Storage::disk('PDF')->get($Ruta); 

                            $codificado = base64_encode($PDF); 
                        
                            $Sha256 = hash('sha256', $PDF);
                
                            $rutaImagen=DB::table('ImagenFirma')->Select('Ruta')->where('id_Funcionario_T', '=', $ID_Funcionario)->first();
                            $rutaImagen2="Firmas/".$rutaImagen->Ruta;
                
                            $contenidoBinario = file_get_contents($rutaImagen2);
                            $imagenComoBase64 = base64_encode($contenidoBinario);
                
                            $AnchoFirma=(($Ancho*35)/100); 
                            $AltoFirma=(($Alto*25)/100);
                    
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

                            if(empty($responseBody->status)){ 
                                
                                if($responseFiles = $responseBody->files!=null){ 

                                    $responseFiles = $responseBody->files;
                                    foreach($responseFiles as $posicion){ 
                                        $status = $posicion->status;
                                    }
                                            
                                    if($status=='OK'){

                                        $responseFiles = $responseBody->files;
                                        $responseidSolicitud = $responseBody->idSolicitud;
                                        foreach($responseFiles as $posicion){ 
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
                                    
                                        if (file_exists($Ruta)){
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

                                        $DestinoDocumento  =  DB::table('DestinoDocumento')->where('Ruta_T', '=',$Ruta)->first();
                
                                        $ID_DestinoDocumento   = $DestinoDocumento->ID_DestinoDocumento ;
                                        
                                        $ID_DocumentoFirma  =  DB::table('DocumentoFirma') 
                                                    ->select('ID_DocumentoFirma')
                                                    ->where('ID_Funcionario', '=',$ID_Funcionario)
                                                    ->where('ID_Documento', '=',$ID_DestinoDocumento)
                                                    ->first();
                
                                        $ID_DocumentoF   = $ID_DocumentoFirma->ID_DocumentoFirma;
                    
                                        $DocumentoFirma             =DocumentoFirma::find($ID_DocumentoF);
                                        $DocumentoFirma->FechaFirma = date("Y/m/d");
                                        $DocumentoFirma->Firmado    = 1;
                                        $DocumentoFirma->save();

                                        $LinkFirma                   = LinkFirma::find($ID_LinkFirma);  
                                        $LinkFirma->Estado           = 2;
                                        $LinkFirma->save(); 

                                        $Datos =  DB::table('LinkFirma')
                                        ->select('ID_Documento_L')->where('ID_LinkFirma', '=',$ID_LinkFirma)->first();

                                        $ID_Documento_T = $Datos->ID_Documento_L; 

                                        $Portafolio              = Portafolio::find($ID_Documento_T);
                                        $Portafolio->Estado_T    = 22;
                                        $Portafolio->save();

                                        $EnviarPortafolio  =  DB::table('LinkFirma') 
                                                    ->select('ID_Documento_L')
                                                    ->where('ID_Documento_L', '=',$LinkFirma->ID_Documento_L)
                                                    ->where(function($query) {  
                                                        $query->orwhere('Estado', '=', 0)
                                                                ->orwhere('Estado', '=', 1)
                                                                ->orwhere('Estado', '=', 3);
                                                        }) 
                                                    ->count();
                                                        
                                        if($EnviarPortafolio==0){
                                            
                                            $Enviar =  DB::table('LinkFirma') 
                                            ->select('ID_Documento_L')
                                            ->where('ID_LinkFirma', '=',$ID_LinkFirma)
                                            ->first();

                                            $ID_Documento_T = $Enviar->ID_Documento_L;

                                            $Portafolio                   = Portafolio::find($ID_Documento_T);  
                                            $Portafolio->Estado_T         = 1;
                                            $Portafolio->save(); 

                                        }    
                                           
                                        
                                        $InterPortaFuncionario             =InterPortaFuncionario::where('IPF_ID_Funcionario', $ID_Funcionario)->where('IPF_Portafolio', $ID_Documento_T)->first();
                                        $InterPortaFuncionario->Visto               = 1;  
                                        $InterPortaFuncionario->Estado              = 1;
                                        $InterPortaFuncionario->save();


                                        //CREAR IMAGEN DE PDF
                                        $mousePosXF = number_format(($mousePosX*100)/$Ancho);
                                        $mousePosXF2 = number_format(($mousePosXF*215)/100);
                                        
                                        $mousePosYF = number_format(($mousePosY*100)/$Alto);
                                        $mousePosYF2 = number_format(($mousePosYF*280)/100);

                                        $pdf = new FPDI(); 
                                        $pagecount =  $pdf->setSourceFile('ImagenPDF'.'/'.$Ruta);
                                        for($i =1; $i<=$pagecount; $i++){
                                    
                                            if($i!=$Pagina){
                                                $pdf->AddPage();
                                                $pdf->setSourceFile('ImagenPDF'.'/'.$Ruta);
                                                $template = $pdf->importPage($i);
                                                $pdf->useTemplate($template,0, 0, 215, 280, true); 
                                            }
                                            else{ 
                                                
                                                $pdf->AddPage();
                                                $pdf->setSourceFile('ImagenPDF'.'/'.$Ruta);   
                                                $template = $pdf->importPage($i);
                                                $pdf->useTemplate($template,0, 0, 215, 280, true);
                                                $pdf->Image('FirmaGeneral/Firma.JPG', $mousePosXF2, $mousePosYF2, 68, 54);
                                            }
                                        }

                                        $pdf->Output('F', 'ImagenPDF/'.$Ruta);
                                        //FIN CREAR IMAGEN DE PDF

                                            //INICIO NUMERO DE FIRMAS
                            
                            $Mes=date("m");
                            $Anio=date("Y");  


                            $Funcionario  =  DB::table('Funcionarios') 
                            ->select('Nombres','Apellidos')
                            ->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

                            $Nombre = $Funcionario->Nombres.' '.$Funcionario->Apellidos;

                            $DatosFunc =  DB::table('FirmadosFunc') 
                            ->where('ID_Func', '=',$ID_Funcionario)
                            ->orderBy('ID_FirmadosFunc', 'desc')->first();


                            if(!empty($DatosFunc)){
                                $DatosFunc1 =  DB::table('FirmadosFunc') 
                                ->where('Mes_Func', '=',$Mes)
                                ->where('Anio_Func', '=',$Anio)
                                ->where('ID_Func', '=',$ID_Funcionario)
                                ->first();

                                if(!empty($DatosFunc1)){
                                    $FirmadosFunc             =FirmadosFunc::find($DatosFunc1->ID_FirmadosFunc);
                                    $FirmadosFunc->NumeroFunc = $DatosFunc1->NumeroFunc+1;
                                    $FirmadosFunc->save(); 
                                }
                                else{

                                    $FirmadosFunc             =new FirmadosFunc;
                                    $FirmadosFunc->Mes_Func   = $Mes;
                                    $FirmadosFunc->Anio_Func  = $Anio;  
                                    $FirmadosFunc->ID_Func    = $ID_Funcionario;
                                    $FirmadosFunc->Nombres    = $Nombre;
                                    $FirmadosFunc->NumeroFunc = 1;
                                    $FirmadosFunc->save();  
                                }
                            }
                            else{
                                $FirmadosFunc             =new FirmadosFunc;
                                $FirmadosFunc->Mes_Func   = $Mes;
                                $FirmadosFunc->Anio_Func  = $Anio;  
                                $FirmadosFunc->ID_Func    = $ID_Funcionario;
                                $FirmadosFunc->Nombres    = $Nombre;
                                $FirmadosFunc->NumeroFunc = 1;
                                $FirmadosFunc->save();  
                            }
                            


                            $Nombre_DepDir  =  DB::table('Funcionarios') 
                            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
                            ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir')
                            ->select('Nombre_DepDir')
                            ->where('Estado_LDT', '=',1)
                            ->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

                            $ID_DD =  DB::table('LugarDeTrabajo')
                            ->select('ID_DepDirecciones_LDT') 
                            ->where('Estado_LDT', '=', 1)         
                            ->where('ID_Funcionario_LDT', '=', $ID_Funcionario)
                            ->first();

                          

                            $DatosDD =  DB::table('FirmadosDD')
                            ->where('ID_DD', '=',$ID_DD->ID_DepDirecciones_LDT)
                            ->orderBy('ID_FIRMADOSDD', 'desc')->first();


                            if(!empty($DatosDD)){
                                $DatosDD1 =  DB::table('FirmadosDD') 
                                ->where('Mes_DD', '=',$Mes)
                                ->where('Anio_DD', '=',$Anio)
                                ->where('ID_DD', '=',$ID_DD->ID_DepDirecciones_LDT)
                                ->first();

                                if(!empty($DatosDD1)){
                                    $FirmadosDD             =FirmadosDD::find($DatosDD1->ID_FIRMADOSDD);
                                    $FirmadosDD->Numero_DD = $DatosDD1->Numero_DD+1;
                                    $FirmadosDD->save(); 
                                }
                                else{

                                    $FirmadosDD             =new FirmadosDD;
                                    $FirmadosDD->Mes_DD   = $Mes;
                                    $FirmadosDD->Anio_DD  = $Anio;  
                                    $FirmadosDD->ID_DD    = $ID_DD->ID_DepDirecciones_LDT;
                                    $FirmadosDD->Nombre   = $Nombre_DepDir->Nombre_DepDir;
                                    $FirmadosDD->Numero_DD= 1;
                                    $FirmadosDD->save();  
                                }
                            }
                            else{
                                $FirmadosDD             =new FirmadosDD;
                                $FirmadosDD->Mes_DD   = $Mes;
                                $FirmadosDD->Anio_DD  = $Anio;  
                                $FirmadosDD->ID_DD    = $ID_DD->ID_DepDirecciones_LDT;
                                $FirmadosDD->Nombre   = $Nombre_DepDir->Nombre_DepDir;
                                $FirmadosDD->Numero_DD= 1;
                                $FirmadosDD->save();  
                            }

                            $DatosAnioDD =  DB::table('AnioDD')
                                    ->where('ID_DD', '=',$ID_DD->ID_DepDirecciones_LDT)
                                    ->orderBy('ID_Anio', 'desc')->first();


                                    if(!empty($DatosAnioDD)){
                                        $DatosDD1 =  DB::table('AnioDD') 
                                        ->where('Anio_DD', '=',$Anio)
                                        ->where('ID_DD', '=',$ID_DD->ID_DepDirecciones_LDT)
                                        ->first();

                                        if(!empty($DatosDD1)){
                                            $AnioDD             =AnioDD::find($DatosDD1->ID_Anio);
                                            $AnioDD->Numero_DD = $DatosDD1->Numero_DD+1;
                                            $AnioDD->save(); 
                                        }
                                        else{

                                            $AnioDD             =new AnioDD;
                                            $AnioDD->Anio_DD  = $Anio;  
                                            $AnioDD->ID_DD    = $ID_DD->ID_DepDirecciones_LDT;
                                            $AnioDD->Nombre   = $Nombre_DepDir->Nombre_DepDir;
                                            $AnioDD->Numero_DD= 1;
                                            $AnioDD->save();  
                                        }
                                    }
                                    else{
                                        $AnioDD             =new AnioDD;
                                        $AnioDD->Anio_DD  = $Anio;  
                                        $AnioDD->ID_DD    = $ID_DD->ID_DepDirecciones_LDT;
                                        $AnioDD->Nombre   = $Nombre_DepDir->Nombre_DepDir;
                                        $AnioDD->Numero_DD= 1;
                                        $AnioDD->save();  
                                    }
                            //FIN NUMERO DE FIRMAS
                                        
                                    }
                                    
                                }
                                else{
                                    $status='ERROR, firma digital';
                                }

                            }
                            else{
                                $status='ERROR, firma digital no registrada';
                            } 
                        }      
                    }                                 
                    else{
                        return back()
                        ->withErrors(['Contraseña Incorrecta'])
                        ->withInput(request(['RUN'])); 
                    }
                    return view('FirmarSolicitud/Resultado', compact('status'));

        }
        else{
            $status=1;  
            return view('FirmarSolicitud/Resultado', compact('status'));
        }
    }
}


