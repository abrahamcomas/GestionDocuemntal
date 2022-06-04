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
use App\Models\FirmadosDD;
use App\Models\FirmadosFunc;
use App\Models\AnioDD;
use App\Models\DestinoDocumento2;
use App\Models\DocumentoFirma;
use Response;
use Illuminate\Support\Facades\DB;  
use ZipArchive;
use Spatie\PdfToImage\pdf;
use Org_Heigl\Ghostscript\Ghostscript;
use Zxing\QrReader;
use Imagick;
use setasign\Fpdi\Fpdi;

class FirmarDocumento extends Controller
{
    public function index(Request $request) 
    {  
        $Ruta  = $request->input('Ruta');
        $RutaImagenFirma  = $request->input('RutaImagenFirma');

        $NombreZip =DB::table('DocumentosExterno')->Select('NombreZip')->where('Ruta_T', '=', $Ruta)->first();

        $NombreZip = $NombreZip->NombreZip;
        
        $Archivos =  DB::table('DocumentosExterno') 
        ->select('NombreDocumento','Ruta_T')
        ->where('NombreZip', '=',$NombreZip )
        ->get();

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;   

        foreach ($Archivos as $Ruta_T) {  
            
            $NuevoNombre = substr($Ruta_T->Ruta_T, 3, -4);
            
            $pdf = new Pdf('PDF/'.$Ruta_T->Ruta_T);
            $NumeroPaginas = $pdf->getNumberOfPages('PDF/'.$Ruta_T->Ruta_T);
            $pdf->setPage($NumeroPaginas)
            ->saveImage('ImagenQRPDF/'.$NuevoNombre.'.png');

            $qrcode= new QrReader('ImagenQRPDF/'.$NuevoNombre.'.png');
            $textQR= $qrcode->text();


            $Ruta = $Ruta_T->Ruta_T; 

            $RutaFinal = date("y").'/'.$Ruta;

            $hoy = date("Y-m-d H:i:s"); 
            $tokenQR = md5($hoy);

            if($textQR==false){
 
                //CREAR IMAGEN DE PDF 
                    $contenido='sgd.municipalidadcurico.cl/MostrarDocumentoQR/'.$Ruta.'';

                    $RutaQR =  substr($Ruta, 4);     // bcdef
    
                    $NuevaRuta = substr($RutaQR, 0, -4);
                    $NuevaRuta2 = $NuevaRuta.'.png';

                    $qrimage= public_path('../public/QR/'.$NuevaRuta.'.png');
                    \QRCode::url($contenido)->setOutfile($qrimage)->png();

                            
                    $pdf = new FPDI(); 
                    $pagecount =  $pdf->setSourceFile('PDF'.'/'.$Ruta);
                    $UltimaPagina=$pagecount;

                    for($i =1; $i<=$pagecount; $i++){
                        
                        if($i!=$UltimaPagina){
                            $pdf->AddPage();
                            $pdf->setSourceFile('PDF'.'/'.$Ruta);
                            $template = $pdf->importPage($i);
                            $pdf->useTemplate($template,0, 0, 215, 280, true);
                        }
                        else{ 
                            $pdf->AddPage();
                            $pdf->setSourceFile('PDF'.'/'.$Ruta);
                            $template = $pdf->importPage($i);
                            $pdf->useTemplate($template,0, 0, 215, 280, true);
                            $pdf->Image('QR/'.$NuevaRuta2, 173, 240, 40, 40);
                            $pdf->SetY(239);
                            $pdf->SetFont('Arial','B',7);
                            $pdf->Cell(172);
                            $pdf->Cell(0,6,utf8_decode("VALIDAR FIRMAS Y V°B°"),0,0,'C');
                            $pdf->Ln(4);
                        }
                    }

                    $pdf->Output('F', 'PDF/'.$Ruta);
        
                    Storage::disk('QR')->delete($NuevaRuta2);
                //FIN CREAR IMAGEN DE PDF
            }

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
                                            
 
                                                
                $PDF = Storage::disk('PDF')->get($Ruta); 

                $codificado = base64_encode($PDF); 
            
                $Sha256 = hash('sha256', $PDF);

                if($RutaImagenFirma==null){

                    $rutaImagen=DB::table('ImagenFirma')->Select('Ruta')->where('id_Funcionario_T', '=', $ID_Funcionario)->first();
                    $rutaImagen2="Firmas/".$rutaImagen->Ruta;
    

                }else{

                    $rutaImagen=DB::table('ImagenFirma')->Select('Ruta')->where('Ruta', '=', $RutaImagenFirma)->first();
                    $rutaImagen2="Firmas/".$rutaImagen->Ruta;
                }
              
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

                            if($textQR==false){
 
                                    $DestinoDocumento2                   = new DestinoDocumento2;
                                    $DestinoDocumento2->ID_FSube         = $ID_Funcionario;
                                    $DestinoDocumento2->Token            = $Ruta; 
                                    $DestinoDocumento2->FechaFirma       = date("Y/m/d");
                                    $DestinoDocumento2->save(); 
                            
                            
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
                            
                            
                            
                            
                            
                                }                

                            if($textQR!=false){  

                                $DestinoDocumento = substr($textQR, 53);
                                
                                $DestinoDocumento2                   = new DestinoDocumento2;
                                $DestinoDocumento2->ID_FSube         = $ID_Funcionario;
                                $DestinoDocumento2->Token            = $DestinoDocumento; 
                                $DestinoDocumento2->FechaFirma       = date("Y/m/d");
                                $DestinoDocumento2->save(); 


                                 //CREAR IMAGEN DE PDF
                                    $mousePosXF = number_format(($mousePosX*100)/$Ancho);
                                    $mousePosXF2 = number_format(($mousePosXF*215)/100);
                                    
                                    $mousePosYF = number_format(($mousePosY*100)/$Alto);
                                    $mousePosYF2 = number_format(($mousePosYF*280)/100);
                                    
                                    $pdf = new FPDI();  
                                    $pagecount =  $pdf->setSourceFile('ImagenPDF'.'/'.$DestinoDocumento);
                                    for($i =1; $i<=$pagecount; $i++){
                                
                                        if($i!=$Pagina){
                                            $pdf->AddPage();
                                            $pdf->setSourceFile('ImagenPDF'.'/'.$DestinoDocumento);
                                            $template = $pdf->importPage($i);
                                            $pdf->useTemplate($template,0, 0, 215, 280, true);
                                        }
                                        else{ 
                                            
                                            $pdf->AddPage();
                                            $pdf->setSourceFile('ImagenPDF'.'/'.$DestinoDocumento);   
                                            $template = $pdf->importPage($i);
                                            $pdf->useTemplate($template,0, 0, 215, 280, true);
                                            $pdf->Image('FirmaGeneral/Firma.JPG', $mousePosXF2, $mousePosYF2, 68, 54);
                                        }
                                    }
        
                            
                                    $pdf->Output('F', 'ImagenPDF/'.$DestinoDocumento);
                                //FIN CREAR IMAGEN DE PDF
                                Storage::disk('ImagenPDF')->delete($Ruta);
                
                            }


                            Storage::disk('ImagenQRPDF')->delete($NuevoNombre.'.png');
                          
                                
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


        //INICIO NUMERO DE FIRMAS
        $ID_Funcionario  = Auth::user()->ID_Funcionario_T;
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

        return view('DocumentosExt/Respuesta')->with('status', $status)->with('nombreArchivo', $nombreArchivo);
    }
}
