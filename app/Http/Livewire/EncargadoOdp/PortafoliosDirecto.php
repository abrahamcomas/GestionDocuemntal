<?php

namespace App\Http\Livewire\EncargadoOdp;

use Livewire\Component;
use Livewire\WithPagination;  
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\DocFunc;
use App\Models\CreDocFunc;
use App\Models\DocumentoFirma;
use App\Models\InterPortaFuncionario;
use App\Models\Portafolio; 
use App\Models\LinkFirma; 
use App\Models\DestinoDocumento;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Spatie\PdfToImage\pdf;
use Org_Heigl\Ghostscript\Ghostscript;
use Zxing\QrReader;
use Imagick;

class PortafoliosDirecto extends Component
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
    //Pagina principal  
    public $Detalles=0;
    public $ID_Documento_T;
    public $IPF_ID; 


    public $FirmadoPorFuncionario;
    public function EnviarDocumento($ID_Documento_T,$IPF_ID){ 

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $Firmado =  DB::table('DestinoDocumento')
        ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento') 
        ->select('ID_DestinoDocumento')
        ->where('ID_Funcionario', '!=', $ID_Funcionario)
        ->where('Firmado', '=',1) 
        ->where('Firmado', '!=',4)
        ->where('DOC_ID_Documento', '=',$ID_Documento_T)->count();

        if($Firmado==0){

            
            $Datos =  DB::table('Portafolio')
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select('Nombres','Apellidos')
            ->where('ID_Documento_T', '=',$ID_Documento_T)->first();

            $this->FirmadoPorFuncionario='El funcionario '.$Datos->Nombres.' '.$Datos->Apellidos.' aún no firma esta solicitud, se recomienda esperar a que dicho usuario firme.';
        }
      


        $InterPortaFuncionario                  =InterPortaFuncionario::find($IPF_ID);
        $InterPortaFuncionario->Visto          = 1;
        $InterPortaFuncionario->save(); 

        $this->ID_Documento_T=$ID_Documento_T;

        $this->IPF_ID=$IPF_ID;

        $this->Detalles=4;
    
    }

    public function VolverPrincipal(){ 
        $this->Detalles=0;
        $this->resetPage(); 
        $this->resetErrorBag(); 
    }  
 

    public $TipoRespuesta; 
    public $ObservacionPortafolio; 
    public function RespuestaPortafolio(){

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

            $InterPortaFuncionario                  =InterPortaFuncionario::find($this->IPF_ID);
            $InterPortaFuncionario->Estado          = 2;
            $InterPortaFuncionario->ObservacionE    = $this->ObservacionPortafolio;
            $InterPortaFuncionario->save(); 

            $Portafolio              = Portafolio::find($this->ID_Documento_T);
            $Portafolio->Encargado   = 3; 
            $Portafolio->Estado_T    = 33; 
            $Portafolio->save(); 


            $Link =  DB::table('LinkFirma')
            ->select('ID_LinkFirma') 
            ->where('ID_Documento_L', '=',  $this->ID_Documento_T)->first();

            if(!empty($Link->ID_LinkFirma)){
                
                $LinkFirma =LinkFirma::find($Link->ID_LinkFirma);
                $Portafolio->Estado     = 33;
                $LinkFirma->delete();   
        
            }
           
            $this->ObservacionPortafolio="";
            $this->Detalles=0;

        session()->flash('message1', 'Solicitud rechazada.');
      
    } 



    public $DocumentoFirmado;

    public function ConfirmarFirma($ID_DestinoDocumento){ 

        $this->DocumentoFirmado =  $ID_DestinoDocumento;

        $this->Detalles=5;

    }
 


    public $ContraseniaFirmado; 
    
    protected $Eliminar = ['ContraseniaFirmado' => 'required'];
    protected $MensajeEliminar = ['ContraseniaFirmado.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    
    public function Firmado(){  
        
    $this->validate($this->Eliminar,$this->MensajeEliminar); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaFirmado], true)){ 
            
            $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

            $ID_OficinaPartes =  DB::table('DocumentoFirma') 
            ->select('ID_DocumentoFirma')
            ->where('ID_Funcionario', '=',$ID_Funcionario)
            ->where('ID_Documento', '=',$this->DocumentoFirmado)
            ->first(); 
 
            $DocumentoFirma             =DocumentoFirma::find($ID_OficinaPartes->ID_DocumentoFirma);
            $DocumentoFirma->FechaFirma = date("Y/m/d");
            $DocumentoFirma->Firmado    = 4;//OMITIR FIRMA
            $DocumentoFirma->save();


            $Cantidad =  DB::table('Portafolio') 
            ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento') 
            ->select('ID_Documento_T') 
            ->where('Firmado', '=',0)
            ->where('ID_Documento_T', '=',  $this->ID_Documento_T)->count(); 

            if($Cantidad==0){
                    
                    $Portafolio             =Portafolio::find($this->ID_Documento_T);
                    $Portafolio->Encargado  = 2;
                    $Portafolio->Estado_T   = 1;
                    $Portafolio->save();
            }

            $Cantidad2 =  DB::table('Portafolio') 
            ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento') 
            ->select('ID_Documento_T') 
            ->where('Firmado', '=', 0)
            ->where('ID_Documento_T', '=',  $this->ID_Documento_T)
            ->where('ID_Funcionario', '=',  $ID_Funcionario)->count(); 


            if($Cantidad2==0){

                    $Portafolio =Portafolio::find($this->ID_Documento_T);
                    $Portafolio->Encargado  = 2;
                    $Portafolio->save();
            }

            $this->Detalles=0;
        }
        else{
            session()->flash('message2', 'Contraseña incorrecta.');  
        }

        $this->ContraseniaFirmado='';   

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
                            $pdf->Image('QR/'.$NuevaRuta2, 183, 250, 30, 30);
                            $pdf->SetY(247);
                            $pdf->SetFont('Arial','B',7);
                            $pdf->Cell(182);
                            $pdf->Cell(0,6,utf8_decode("VALIDAR FIRMAS Y V°B°"),0,0,'C');
                            $pdf->Ln(4);
                        }
                    } 
         
                    $pdf->Output('F', 'PDF/'.date("y").'/'.$codificado);

                    $pdf->Output('F', 'ImagenPDF/'.date("y").'/'.$codificado);
    
                    Storage::disk('QR')->delete($NuevaRuta2);
                    Storage::disk('ImagenQRPDF')->delete($NuevoNombre.'.png');
    
                    Storage::disk('PDF')->delete($codificado);

                $this->PDF=[];

                }else{  
 
                    $token = substr($textQR, 53);

                    $DestinoDocumento                   = new DestinoDocumento;
                    $DestinoDocumento->ID_FSube         = $Funcionario;
                    $DestinoDocumento->DOC_ID_Documento = $ID_Documento_T;
                    $DestinoDocumento->Token            = $token; 
                    $DestinoDocumento->NombreDocumento  = $Archivos->getClientOriginalName(); 
                    $DestinoDocumento->Ruta_T           = $token;   
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
 




    
    public function EliminarArchivo($ID_DestinoDocumento){ 

            $VistoBueno =  DB::table('DestinoDocumento')->select('Ruta_T') 
            ->where('ID_DestinoDocumento', '=',$ID_DestinoDocumento)->first();


            $codificado = Storage::disk('PDF')->delete($VistoBueno->Ruta_T);
                
            $DestinoDocumento                   = DestinoDocumento::find($ID_DestinoDocumento);
            $DestinoDocumento->delete();
     

    }




    






    public $Funcionarios; 
    public $Existe;

    //Crear imagen firma 
    public $Nombres;
    public $Apellidos;
    public $Rut;
    public $Oficina;
    public $Cargo;
    public $Creado=1;
    public $cuantos;

    public function Creada(){  
        $this->Creado = 0;  
    }

    public function render()
    {

        $this->Funcionarios =  DB::table('Funcionarios')->get();

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $Cuantos =  DB::table('DestinoDocumento')
        ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento') 
        ->select('ID_DestinoDocumento')
        ->where('ID_Funcionario', '=', $ID_Funcionario)
        ->where('Firmado', '=',0)
        ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->get();

        $this->cuantos=count($Cuantos);

        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->select('Rut','Nombres','Apellidos','Nombre_DepDir','Cargo','ID_DepDir')->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();
  
        $this->Rut = $DatosFirma->Rut;
        $this->Nombres = $DatosFirma->Nombres; 
        $this->Apellidos = $DatosFirma->Apellidos; 
        $this->Oficina = $DatosFirma->Nombre_DepDir;
        $this->Cargo = $DatosFirma->Cargo;

        $ID_DepDir = $DatosFirma->ID_DepDir;

        $Lista =  DB::table('ImagenFirma')  
        ->where('id_Funcionario_T', '=',$ID_Funcionario)
        ->get(); 

        $this->Existe=count($Lista);
     
        return view('livewire.encargado-odp.portafolios-directo',[
        'posts' =>  DB::table('InterPortaFuncionario')
            ->leftjoin('Portafolio', 'InterPortaFuncionario.IPF_Portafolio', '=', 'Portafolio.ID_Documento_T')
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')     
            ->where(function($query) {  
                $query->orwhere('Estado_T', '=', 11)
                        ->orwhere('Estado_T', '=', 22)
                        ->orwhere('Estado_T', '=', 44);
                })   
            ->where('Estado', '!=', 2)    
            ->where('Encargado', '=', 1)         
            ->where('IPF_ID_Funcionario', '=', $ID_Funcionario)
            ->orderBy('IPF_ID', 'asc')    
            ->get(),
        
        'MostrarDocumentosSubidos' =>  DB::table('DestinoDocumento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
            ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('ID_FSube','NombreDocumento','ID_DestinoDocumento','ID_DocumentoFirma','ID_Funcionario','ID_Documento','FechaFirma','Firmado','Nombres','Apellidos')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
            ->where('ID_FSube', '=',$ID_Funcionario)
            ->where('ID_Funcionario', '=',$ID_Funcionario)->paginate(4),

        'MostrarDocumentos' =>  DB::table('DestinoDocumento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
            ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('ID_FSube','NombreDocumento','ID_DestinoDocumento','ID_DocumentoFirma','ID_Funcionario','ID_Documento','FechaFirma','Firmado','Nombres','Apellidos')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
            ->where('ID_Funcionario', '=',$ID_Funcionario)->paginate(4),
        
        'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
            ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select("Nombres","Apellidos")->where('ID_OP_LDT', '=',$ID_DepDir)
            ->first(),

        ]);
    }
}
