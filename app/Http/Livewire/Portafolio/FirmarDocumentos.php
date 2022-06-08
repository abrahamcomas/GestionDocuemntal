<?php

namespace App\Http\Livewire\Portafolio;

use Livewire\Component;
use Livewire\WithPagination; 
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Auth; 
use App\Models\Portafolio;
use App\Models\DocumentoFirma; 
use Illuminate\Support\Facades\Storage;
use App\Models\DestinoDocumento;
use App\Models\Documento;
use App\Models\InterPortaFuncionario;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSecretaria;   

use setasign\Fpdi\Fpdi;
use Spatie\PdfToImage\Pdf;
use Org_Heigl\Ghostscript\Ghostscript;
use Zxing\QrReader;
use Imagick;



class FirmarDocumentos extends Component
{
    public $Ayuda=0; 
    
    public function Ayuda(){
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }
    
    use WithPagination;  
    use WithFileUploads; 
    public $search; 
    public $perPage = 5;
    //Pagina principal  
    public $Detalles=0;
    public $ID_Documento_T;
 
    public $ID_Documento_T2;
    public $Per_Subir;
    
    
    public function EnviarDocumento($ID_Documento_T){

        $this->ID_Documento_T2=$ID_Documento_T;
         
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

        $VerificarDocumentos =  DB::table('DestinoDocumento') 
        ->where('DOC_ID_Documento', '=',$ID_Documento_T)
        ->get();   
        
        $TotalSiHayDocumentos= count($VerificarDocumentos);

        if($TotalSiHayDocumentos>=1){

                $TotalDocumentos =  DB::table('DestinoDocumento') 
                ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
                ->select('Firmado')
                ->where('DOC_ID_Documento', '=',$ID_Documento_T)
                ->where('ID_Funcionario', '=',$ID_Funcionario) 
                ->where('Firmado', '=', 0)
                ->get();   
    
                $Total= count($TotalDocumentos);
            
                if($Total==0){
                
                        $this->Detalles=4;
                        $this->ID_Documento_T=$ID_Documento_T;
                    
                
                }
                else{
        
                        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
                    
                        $TotalDocumentos =  DB::table('DestinoDocumento') 
                        ->where('ID_FSube', '=',$ID_Funcionario)
                        ->where('DOC_ID_Documento', '=',$ID_Documento_T)
                        ->get();
                        
                        $Total= count($TotalDocumentos);
                        
                        $DocumentosFirmados =  DB::table('DestinoDocumento') 
                        ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
                        ->select('Firmado')
                        ->where('ID_FSube', '=',$ID_Funcionario)
                        ->where('DOC_ID_Documento', '=',$ID_Documento_T)
                        ->where('Firmado', '=', 1)
                        ->get();
             
                        $TotalFirmados= count($DocumentosFirmados);
            
                        if($Total==0){
                            $this->Per_Subir=1;
                 
                        }
                        elseif($Total==$TotalFirmados){
                
                            $this->Per_Subir=0;
                        
                        }
                        elseif($Total!=$TotalFirmados){
                            
                            $this->Per_Subir=1;
                        
                        }
                    
                        $this->ID_Documento_T=$ID_Documento_T;
                        $this->Detalles=2;
                }

        }
        else{

            $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
                    
            $TotalDocumentos =  DB::table('DestinoDocumento') 
            ->where('ID_FSube', '=',$ID_Funcionario)
            ->where('DOC_ID_Documento', '=',$ID_Documento_T)
            ->get();
            
            $Total= count($TotalDocumentos);
            
            $DocumentosFirmados =  DB::table('DestinoDocumento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
            ->select('Firmado')
            ->where('ID_FSube', '=',$ID_Funcionario)
            ->where('DOC_ID_Documento', '=',$ID_Documento_T)
            ->where('Firmado', '=', 1)
            ->get();

            $TotalFirmados= count($DocumentosFirmados);

            if($Total==0){
                $this->Per_Subir=1;
    
            }
            elseif($Total==$TotalFirmados){
    
                $this->Per_Subir=0;
            
            }
            elseif($Total!=$TotalFirmados){
                
                $this->Per_Subir=1;
            
            }
        
            $this->ID_Documento_T=$ID_Documento_T;
            $this->Detalles=2;
        }
        
    }

    public function ConfirmarEnvioOPD($ID_Documento_T){
        $this->ID_Documento_T2=$ID_Documento_T;
         
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

                $TotalDocumentos =  DB::table('DestinoDocumento') 
                ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
                ->select('Firmado')
                ->where('DOC_ID_Documento', '=',$ID_Documento_T)
                ->where('ID_Funcionario', '=',$ID_Funcionario) 
                ->where('Firmado', '=', 0)
                ->get();   
    
                $Total= count($TotalDocumentos);
            
                if($Total==0){
                
                        $this->Detalles=9;
                        $this->ID_Documento_T=$ID_Documento_T;
                    
                
                }
                else{
        
                        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
                    
                        $TotalDocumentos =  DB::table('DestinoDocumento') 
                        ->where('ID_FSube', '=',$ID_Funcionario)
                        ->where('DOC_ID_Documento', '=',$ID_Documento_T)
                        ->get();
                        
                        $Total= count($TotalDocumentos);
                        
                        $DocumentosFirmados =  DB::table('DestinoDocumento') 
                        ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
                        ->select('Firmado')
                        ->where('ID_FSube', '=',$ID_Funcionario)
                        ->where('DOC_ID_Documento', '=',$ID_Documento_T)
                        ->where('Firmado', '=', 1)
                        ->get();
             
                        $TotalFirmados= count($DocumentosFirmados);
            
                        if($Total==0){
                            $this->Per_Subir=1;
                 
                        }
                        elseif($Total==$TotalFirmados){
                
                            $this->Per_Subir=0;
                        
                        }
                        elseif($Total!=$TotalFirmados){
                            
                            $this->Per_Subir=1;
                        
                        }
                    
                        $this->ID_Documento_T=$ID_Documento_T;
                        $this->Detalles=9;
                }

    }


    public function VolverPrincipal(){
        $this->Detalles=0;
        $this->resetPage();  
        $this->resetErrorBag();  
    }

    public function SubirArchivos(){
        $this->Detalles=2; 
        $this->resetPage();  
        $this->resetErrorBag(); 
    }

  
    public function VolverArchivos(){
      
        $this->Detalles=2;
    }

    public $ID_EliminarDocumento;
    public function ConfirmarEliminar($ID_DestinoDocumento){
        $this->ID_EliminarDocumento = $ID_DestinoDocumento;
      
        $this->Detalles=6;
    }


    public $ContraseniaDocumento;
    
    protected $EliminarD = ['ContraseniaDocumento' => 'required'];
    protected $MensajeEliminarD = ['ContraseniaDocumento.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    
    public function EliminarArchivo(){ 

        $this->validate($this->EliminarD,$this->MensajeEliminarD); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaDocumento], true))
        { 

            $VistoBueno =  DB::table('DestinoDocumento')->select('Ruta_T') 
            ->where('ID_DestinoDocumento', '=',$this->ID_EliminarDocumento)->first();


            $codificado = Storage::disk('PDF')->delete($VistoBueno->Ruta_T);
            $codificado = Storage::disk('ImagenPDF')->delete($VistoBueno->Ruta_T);
                
                $DestinoDocumento                   = DestinoDocumento::find($this->ID_EliminarDocumento);
                $DestinoDocumento->delete();
     
                $this->resetPage();
                
                if($DestinoDocumento){
                    session()->flash('message', 'Archivo Eliminado correctamente.');

                }
                else{

                    session()->flash('message2', 'Error al eliminar archivo.');
                } 
        } 
        else{
            session()->flash('message2', 'Contraseña incorrecta.');  
        }
        
        $this->ContraseniaDocumento='';    
        $this->Detalles=2; 
    }

    public function DocumentosSubidosTotal(){
        $this->Detalles=8;

    }


 

    public $ObservacionE;
    
    public function ConfirmarEnvio(){

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
   
        $OficinaDePartes =  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->leftjoin('OficinaPartes', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'OficinaPartes.ID_OP_LDT')
            ->select('Id_OP')
            ->where('ID_Funcionario_T', '=', $ID_Funcionario)
            ->first();

        $ID_OficionaPartes =  $OficinaDePartes->Id_OP;

        $Portafolio              = Portafolio::find($this->ID_Documento_T2);
        $Portafolio->ID_OficinaP = $ID_OficionaPartes;
        $Portafolio->Estado_T    = 1;
        $Portafolio->save();

        $this->ObservacionE=""; 
 
        $this->Detalles=0;

        session()->flash('message', 'Solicitud enviada correctamente. Numero interno '.$Portafolio->NumeroInterno.$Portafolio->Anio);

         /*EMAIL

         $DatosEmisor=DB::table('Funcionarios')->Select('Nombres','Apellidos','Email')->where('ID_Funcionario_T','=', $ID_Funcionario)->first();

         $DatosReceptor =  DB::table('LugarDeTrabajo') 
             ->leftjoin('OficinaPartes', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'OficinaPartes.ID_OP_LDT') 
             ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
             ->select("Nombres","Apellidos","Email")->where('ID_Funcionario_LDT', '=',$ID_Funcionario)->first();
 
         $Email = $DatosReceptor->Email; 
    
         Mail::to($Email)->send(new EmailSecretaria($DatosEmisor,$DatosReceptor)); 
 
 
         */

      
    }


    public function ConfirmarEnvio2($ID_Documento_T){

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
   
        $OficinaDePartes =  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->leftjoin('OficinaPartes', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'OficinaPartes.ID_OP_LDT')
            ->select('Id_OP')
            ->where('ID_Funcionario_T', '=', $ID_Funcionario)
            ->first();

        $ID_OficionaPartes =  $OficinaDePartes->Id_OP;

        $Portafolio              = Portafolio::find($ID_Documento_T);
        $Portafolio->ID_OficinaP = $ID_OficionaPartes;
        $Portafolio->Estado_T    = 1;
        $Portafolio->save();

        $this->ObservacionE="";

        session()->flash('message', 'Solicitud enviada correctamente. Numero interno '.$Portafolio->NumeroInterno.$Portafolio->Anio);

        $this->Detalles=0;
    }

    public function VolverListaDocumentos(){

        $this->Detalles=4;
    }


    public $PDF= [];
    protected $rules3 = ['PDF' => 'required'];
    protected $messages3 = ['PDF.required' =>'El campo ARCHIVO/S es obligatorio.'];
    public function Ingresar(){ 
        
        $this->validate($this->rules3,$this->messages3); 
        $Funcionario  =  Auth::user()->ID_Funcionario_T;
             
             
 
            foreach ($this->PDF as $Archivos) {
                $codificado = Storage::disk('PDF')->put('', $Archivos);

                $NuevoNombre = substr($codificado, 0, -4);
            
                $pdf = new Pdf('PDF/'.$codificado);
                $NumeroPaginas = $pdf->getNumberOfPages('PDF/'.$codificado);
                $pdf->setPage($NumeroPaginas)
                ->saveImage('ImagenQRPDF/'.$NuevoNombre.'.png');
    
                $qrcode= new QrReader('ImagenQRPDF/'.$NuevoNombre.'.png');
                $textQR= $qrcode->text();
    
                if($textQR==false){

                        //Nueva Ruta
                        $NuevaRuta = date("y");
                        $NuevaRutaF = Storage::disk('PDF')->put($NuevaRuta, $Archivos);
                        Storage::disk('ImagenPDF')->put($NuevaRuta, $Archivos);
                        //FIN
     
                    //CREAR IMAGEN DE PDF
                    $hoy = date("Y-m-d H:i:s"); 
                    $token = md5($hoy);

                    $DestinoDocumento                    = new DestinoDocumento;
                    $DestinoDocumento->ID_FSube         = $Funcionario;
                    $DestinoDocumento->DOC_ID_Documento = $this->ID_Documento_T; 
                    $DestinoDocumento->Token            = $token; 
                    $DestinoDocumento->NombreDocumento  = $Archivos->getClientOriginalName(); 
                    $DestinoDocumento->Ruta_T           = $NuevaRutaF;   
                    $DestinoDocumento->save();

                    $DocumentoFirma                  = new DocumentoFirma;
                    $DocumentoFirma->ID_Funcionario  = $Funcionario;
                    $DocumentoFirma->ID_Documento    = $DestinoDocumento->ID_DestinoDocumento;  
                    $DocumentoFirma->Firmado         = 0;  
                    $DocumentoFirma->save(); 

                    $contenido='sgd.municipalidadcurico.cl/MostrarDocumentoQR/'.$token.'';

                    $NuevaRuta = substr($codificado, 0, -4);
                    $NuevaRuta2 = $NuevaRuta.'.png';

                    $qrimage= public_path('../public/QR/'.$NuevaRuta.'.png');
                    \QRCode::url($contenido)->setOutfile($qrimage)->png();

                                
                    $pdf = new FPDI(); 
                    $pagecount =  $pdf->setSourceFile('PDF'.'/'.$codificado);
                    $UltimaPagina=$pagecount; 
        
                for($i =1; $i<=$pagecount; $i++){
                    
                    if($i!=$UltimaPagina){
                        $pdf->AddPage();
                        $pdf->setSourceFile('PDF'.'/'.$codificado);
                        $template = $pdf->importPage($i);
                        $pdf->useTemplate($template,0, 0, 215, 280, true);
                    }
                    else{  
                        $pdf->AddPage();
                        $pdf->setSourceFile('PDF'.'/'.$codificado);
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
         

                $pdf->Output('F', 'PDF/'.date("y").'/'.$codificado);

                $pdf->Output('F', 'ImagenPDF/'.date("y").'/'.$codificado);

                Storage::disk('QR')->delete($NuevaRuta2);
                Storage::disk('ImagenQRPDF')->delete($NuevoNombre.'.png');

                Storage::disk('PDF')->delete($codificado);
            //FIN CREAR IMAGEN DE PDF
        }else{  
                $token = substr($textQR, 53);


                $DestinoDocumento                    = new DestinoDocumento;
                $DestinoDocumento->ID_FSube         = $Funcionario;
                $DestinoDocumento->DOC_ID_Documento = $this->ID_Documento_T; 
                $DestinoDocumento->Token            = $token; 
                $DestinoDocumento->NombreDocumento  = $Archivos->getClientOriginalName(); 
                $DestinoDocumento->Ruta_T           = $NuevaRutaF;   
                $DestinoDocumento->save();

                $DocumentoFirma                  = new DocumentoFirma;
                $DocumentoFirma->ID_Funcionario  = $Funcionario;
                $DocumentoFirma->ID_Documento    = $DestinoDocumento->ID_DestinoDocumento;  
                $DocumentoFirma->Firmado         = 0;   
                $DocumentoFirma->save();
                

        }
 

               


            }
            session()->flash('message', 'Documento agregado correctamente.');     
    }

    public function clear()
    {
      $this->search='';
      $this->perPage='5';
    }

    public $EliminarPortafolio;
    public function EliminarPortafolio($ID_Documento_T){ 

        $this->EliminarPortafolio = $ID_Documento_T;
      
        $this->Detalles=3;

    }




   



    public $DocumentoFirmado;

    public function ConfirmarFirma($ID_DestinoDocumento){ 

        $this->DocumentoFirmado =  $ID_DestinoDocumento;

        $this->Detalles=5;

    }

    public function ConfirmarFirmaTodos(){ 

        $this->Detalles=10;

    }

    public $ContraseniaFirmado; 
    
    protected $Eliminar = ['ContraseniaFirmado' => 'required'];
    protected $MensajeEliminar = ['ContraseniaFirmado.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    
    public function Firmado(){ 
        
    $this->validate($this->Eliminar,$this->MensajeEliminar); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaFirmado], true)){ 
            
            $ID_OficinaPartes =  DB::table('DocumentoFirma') 
            ->select('ID_DocumentoFirma')
            ->where('ID_Documento', '=',$this->DocumentoFirmado)
            ->first();
 
            $DocumentoFirma             =DocumentoFirma::find($ID_OficinaPartes->ID_DocumentoFirma);
            $DocumentoFirma->FechaFirma = date("Y/m/d");
            $DocumentoFirma->Firmado    = 4;//OMITIR FIRMA
            $DocumentoFirma->save();



            //CREAR IMAGEN DE PDF
            $Ruta_T =  DB::table('DocumentoFirma') 
            ->leftjoin('DestinoDocumento', 'DocumentoFirma.ID_Documento', '=', 'DestinoDocumento.ID_DestinoDocumento')
            ->select('Ruta_T')
            ->where('ID_Documento', '=',$this->DocumentoFirmado)
            ->first();
    
              
            $pdf = new FPDI(); 
            $pagecount =  $pdf->setSourceFile('PDF'.'/'.$Ruta_T->Ruta_T);
            for($i =1; $i<=$pagecount; $i++){

                $pdf->AddPage();
                $pdf->setSourceFile('PDF'.'/'.$Ruta_T->Ruta_T);
                $template = $pdf->importPage($i);
                $pdf->useTemplate($template,0, 0, 215, 280, true);
               
            }
 
            $pdf->Output('F', 'ImagenPDF/'.$Ruta_T->Ruta_T);
            //FIN CREAR IMAGEN DE PDF

            $this->Detalles=0;
        }
        else{
            session()->flash('message2', 'Contraseña incorrecta.');  
        }

        $this->ContraseniaFirmado='';   

    }

 



    public $ContraseniaFirmadoTodos; 
    protected $EliminarTodos = ['ContraseniaFirmadoTodos' => 'required'];

    protected $MensajeEliminarTodos = ['ContraseniaFirmadoTodos.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    
    public function FirmadoTodos(){ 
        
        $this->validate($this->EliminarTodos,$this->MensajeEliminarTodos); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaFirmadoTodos], true)){ 
            
            $DestinoDocumento =  DB::table('DestinoDocumento') 
            ->select('Ruta_T')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T2)
            ->get();

            foreach ($DestinoDocumento as $Ruta_T) {  

                $ID_DestinoDocumento =  DB::table('DestinoDocumento') 
                ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
                ->select('ID_DocumentoFirma')
                ->where('Ruta_T', '=',$Ruta_T->Ruta_T)
                ->first();

                $DocumentoFirma             =DocumentoFirma::find($ID_DestinoDocumento->ID_DocumentoFirma);
                $DocumentoFirma->FechaFirma = date("Y/m/d");
                $DocumentoFirma->Firmado    = 1;
                $DocumentoFirma->save();

                //CREAR IMAGEN DE PDF
        
                $pdf = new FPDI(); 
                $pagecount =  $pdf->setSourceFile('PDF'.'/'.$Ruta_T->Ruta_T);
                for($i =1; $i<=$pagecount; $i++){

                    $pdf->AddPage();
                    $pdf->setSourceFile('PDF'.'/'.$Ruta_T->Ruta_T);
                    $template = $pdf->importPage($i);
                    $pdf->useTemplate($template,0, 0, 215, 280, true);
                
                }

                $pdf->Output('F', 'ImagenPDF/'.$Ruta_T->Ruta_T);
                //FIN CREAR IMAGEN DE PDF  
            }
            $this->Detalles=0;
        }
        else{
            session()->flash('message2', 'Contraseña incorrecta.');  
        }

        $this->Contrasenia='';   

    }










    public $ContraseniaPortafolio;
    protected $EliminarFirmante = ['ContraseniaPortafolio' => 'required'];
    protected $MensajeEliminarFirmante = ['ContraseniaPortafolio.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    public function EliminarPortafolioConf(){

        $this->validate($this->EliminarFirmante,$this->MensajeEliminarFirmante); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaPortafolio], true)){ 
            
            $ID_OficinaPartes =  DB::table('Portafolio') 
            ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
            ->select('Ruta_T')
            ->where('DOC_ID_Documento', '=',$this->EliminarPortafolio)
            ->get();
    
            foreach ($ID_OficinaPartes as $Archivos) {  
     
                $codificado = Storage::disk('PDF')->delete($Archivos->Ruta_T);
                $codificado = Storage::disk('ImagenPDF')->delete($Archivos->Ruta_T);
                
            }   

            $VistoBueno =Portafolio::find($this->EliminarPortafolio);
            $VistoBueno->delete();  

            $IPF_ID =  DB::table('InterPortaFuncionario') 
            ->select('IPF_ID')
            ->where('IPF_Portafolio', '=',$this->EliminarPortafolio)
            ->first();

            if(!empty($IPF_ID->IPF_ID)){
                $IPF_ID = $IPF_ID->IPF_ID;

                $InterPortaFuncionario =InterPortaFuncionario::find($IPF_ID);
                $InterPortaFuncionario->delete();
            }    

            session()->flash('message', 'Solicitud eliminada correctamente.');
            
            $this->Detalles=0; 
            
            $this->ContraseniaPortafolio="";
        }
        else{
            $this->ContraseniaPortafolio="";
            
            session()->flash('message2', 'Contraseña incorrecta.');  
        }

    }












 


    public $MensajeRechazo;
    public $Mostrar=0;
    public function MensajeRechazo($ID_Documento_T){

        $ObservacionE =  DB::table('InterPortaFuncionario')
        ->select('ObservacionE')
        ->orderBy('IPF_ID', 'desc')
        ->where('IPF_Portafolio', '=',$ID_Documento_T)->first();

        $this->MensajeRechazo = $ObservacionE->ObservacionE;

        session()->flash('message2', $this->MensajeRechazo);

        $this->Mostrar=1;


    }

    public $NombreEncargado;
    public $ApellidoEncargado;
    public $ID_Jefatura;
    public function SolicitarFirma(){ 
      
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;  

        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->select('ID_DepDirecciones_LDT')
        ->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

        $ID_DepDir = $DatosFirma->ID_DepDirecciones_LDT;

        $DatosEncargado =  DB::table('OficinaPartes') 
        ->leftjoin('Funcionarios', 'OficinaPartes.ID_Jefatura', '=', 'Funcionarios.ID_Funcionario_T') 
        ->select("ID_Funcionario_T","Nombres","Apellidos")->where('ID_OP_LDT', '=',$ID_DepDir)
        ->first();

        $this->NombreEncargado = $DatosEncargado->Nombres;
        $this->ApellidoEncargado = $DatosEncargado->Apellidos;
        $this->ID_Jefatura = $DatosEncargado->ID_Funcionario_T;

        $this->Detalles=7;
    } 


    public function EnvioDirectoJefatura(){   


 
        $Portafolio              = Portafolio::find($this->ID_Documento_T2);
        $Portafolio->Encargado   = 1;
        $Portafolio->Estado_T    = 11;
        $Portafolio->save();

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;


        $LugarDeTrabajo =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->select('ID_DepDirecciones_LDT')  
        ->where('ID_Funcionario_T', '=', $ID_Funcionario)->first();

        $OficinaPartes =  DB::table('OficinaPartes')
        ->select('Id_OP','ID_OP_LDT')  
        ->where('ID_OP_LDT', '=', $LugarDeTrabajo->ID_DepDirecciones_LDT)->where('Original', '=', 1)->first(); 
 
    
        $InterPortaFuncionario                      = new InterPortaFuncionario;
        $InterPortaFuncionario->IPF_ID_Funcionario  = $this->ID_Jefatura;
        $InterPortaFuncionario->IPF_Portafolio      = $this->ID_Documento_T2;  
        $InterPortaFuncionario->IPF_Id_OP           = $OficinaPartes->Id_OP;  
        $InterPortaFuncionario->ID_OP_LDT_P_IP      = $OficinaPartes->ID_OP_LDT;  
        $InterPortaFuncionario->FechaR              = date("Y/m/d");  
        $InterPortaFuncionario->Visto               = 0;  
        $InterPortaFuncionario->Estado              = 11;
        $InterPortaFuncionario->save(); 
         
        
        $ID_OficinaPartes =  DB::table('DestinoDocumento') 
                                ->select('ID_DestinoDocumento')
                                ->where('DOC_ID_Documento', '=',$this->ID_Documento_T2)
                                ->get();

                                foreach ($ID_OficinaPartes as $Firmas){  

                                   
                                    $VariableFirma =  DB::table('DocumentoFirma') 
                                    ->select('ID_Funcionario','ID_Documento')
                                    ->where('ID_Funcionario', '=',$this->ID_Jefatura)
                                    ->where('ID_Documento', '=',$Firmas->ID_DestinoDocumento)
                                    ->get();
                                    
                                    $ExisteFirma= count($VariableFirma);   
                                    
                                    if($ExisteFirma==0){
                            
                                        $DocumentoFirma                  = new DocumentoFirma;
                                        $DocumentoFirma->ID_Funcionario  = $this->ID_Jefatura;
                                        $DocumentoFirma->ID_Documento    = $Firmas->ID_DestinoDocumento;  
                                        $DocumentoFirma->Firmado         = 0;  
                                        $DocumentoFirma->save(); 
                                    
                                    
                                    
                                    }
                                
                                
                                }



                                $this->Detalles=0; 


    }























    public $Funcionarios;
    public $NombreEncargado2;
    public $ApellidoEncargado2;
    public $cuantos;

    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {


        $this->Funcionarios =  DB::table('Funcionarios')->get();

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;  
 
        
        $Cuantos =  DB::table('DestinoDocumento')
        ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento') 
        ->select('ID_DestinoDocumento')
        ->where('ID_Funcionario', '=', $ID_Funcionario)
        ->where('Firmado', '=',0)
        ->where('DOC_ID_Documento', '=',$this->ID_Documento_T2)->get();

        $this->cuantos=count($Cuantos);






        

        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->select('ID_DepDirecciones_LDT')
        ->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

        $ID_DepDir = $DatosFirma->ID_DepDirecciones_LDT;

        $DatosEncargado =  DB::table('OficinaPartes') 
        ->leftjoin('Funcionarios', 'OficinaPartes.ID_Jefatura', '=', 'Funcionarios.ID_Funcionario_T') 
        ->select("ID_Funcionario_T","Nombres","Apellidos")->where('ID_OP_LDT', '=',$ID_DepDir)
        ->first();
 
        $this->NombreEncargado2 = $DatosEncargado->Nombres;
        $this->ApellidoEncargado2 = $DatosEncargado->Apellidos;

        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->select('ID_DepDir')->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

        $ID_DepDir = $DatosFirma->ID_DepDir;

        return view('livewire.portafolio.firmar-documentos',[
		'posts' =>  DB::table('Portafolio') 
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->where(function($query) {  
                $query->orwhere('Estado_T', '=', 0)
                        ->orwhere('Estado_T', '=', 11)
                        ->orwhere('Estado_T', '=', 22)
                        ->orwhere('Estado_T', '=', 33)
                        ->orwhere('Estado_T', '=', 44);
                })   
            ->where(function($query) {   
                $query->orwhere('Folio', 'like', "%{$this->search}%")
                        ->orwhere('Titulo_T', 'like', "%{$this->search}%")
                        ->orwhere('Tipo_T', 'like', "%{$this->search}%") 
                        ->orwhere('Observacion_T', 'like', "%{$this->search}%");
                })         
            ->where('ID_Funcionario_Sol', '=', $ID_Funcionario)->orderBy('Estado_T', 'asc')   
            ->paginate($this->perPage), 
        
            'MostrarDocumentos' =>  DB::table('DestinoDocumento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
            ->select('ID_FSube','ID_DestinoDocumento','NombreDocumento','ID_DocumentoFirma','ID_Documento','FechaFirma','Firmado')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
            ->where('ID_Funcionario', '=',$ID_Funcionario)->get(), 
            
            'DocumentosSubidosTotal' =>  DB::table('DestinoDocumento') 
            ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('Nombres','Apellidos','NombreDocumento','ID_DestinoDocumento')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->paginate(4), 
            'NombreOficinaParte' =>  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->select('Nombre_DepDir')
            ->where('ID_Funcionario_T', '=', $ID_Funcionario)
            ->first(),
        ]);
    }
} 
  