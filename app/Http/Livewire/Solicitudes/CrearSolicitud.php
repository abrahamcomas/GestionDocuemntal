<?php

namespace App\Http\Livewire\Solicitudes;

use Livewire\Component;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage;
use App\Models\Portafolio11;
use App\Models\DocumentoFirma11;
use App\Models\DestinoDocumento11;
use App\Models\LinkFirma11;
use App\Models\InterPortaFuncionario;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Fpdi;


class CrearSolicitud extends Component
{

    public $Ayuda=0; 
    public $search; 

    public function Ayuda(){ 
        $this->Ayuda = 1;
    } 
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }
      
    use WithFileUploads;

    public $SelecNombres; 
    public $SelecApellidos; 
    public $SelecEmail; 
    public $SelecID_Funcionario_T; 

    public function SeleccionarFunc($ID_Funcionario_T){

        $Datos  =  DB::table('Funcionarios') 
        ->select('ID_Funcionario_T','Nombres','Apellidos','Email')
        ->where('ID_Funcionario_T', '=',$ID_Funcionario_T)
        ->first();

        $this->SelecNombres = $Datos->Nombres;
        $this->SelecApellidos = $Datos->Apellidos;
        $this->SelecEmail = $Datos->Email;
        $this->SelecID_Funcionario_T = $ID_Funcionario_T;
    }

    public $SoloTitulo;
    public $PDF= [];
    public $Pagina=0; 

    protected $rules = ['SelecID_Funcionario_T' => 'required',
                        'SoloTitulo' => 'required',   
                        'PDF' => 'required']; 

	protected $messages = [ 'SelecID_Funcionario_T.required' =>'El campo "CREAR SOLICITUD A" es obligatorio.',
                            'SoloTitulo.required' =>'El campo "TÍTULO" es obligatorio.',
                            'PDF.required' =>'El campo "Archivo" es obligatorio.'];

    public function Ingresar()
    {   
        $this->validate(); 
                
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

        $Portafolio11                    = new Portafolio11;
        $Portafolio11->ID_Funcionario_Sol= $ID_Funcionario;
        $Portafolio11->Estado_T          = 0;
        $Portafolio11->Titulo_T          = $this->SoloTitulo;
        $Portafolio11->Fecha_T           = date("Y/m/d"); 
        $Portafolio11->Anio              = date("y"); 
        $Portafolio11->save();  
       
        $LinkFirma11                   = new LinkFirma11;
        $LinkFirma11->ID_Documento_L   = $Portafolio11->ID_Documento_T; 
        $LinkFirma11->Titulo_T         = $this->SoloTitulo; 
        $LinkFirma11->ID_Funcionario_L = $this->SelecID_Funcionario_T;   
        $LinkFirma11->Nombres_L        = $this->SelecNombres; 
        $LinkFirma11->Apellidos_L      = $this->SelecApellidos; 
        $LinkFirma11->Estado           = 0;
        $LinkFirma11->Email            = 0;
        $LinkFirma11->direccionEmail   = $this->SelecEmail; 
        $LinkFirma11->save();
    
        $ID_Documento_T  = $Portafolio11->ID_Documento_T;     
     
        foreach ($this->PDF as $Archivos) {  
    
            $codificado = Storage::disk('PDF')->put('', $Archivos);

            $token = md5($Archivos->getClientOriginalName());
    
            $DestinoDocumento11                   = new DestinoDocumento11;
            $DestinoDocumento11->ID_FSube         = $ID_Funcionario;
            $DestinoDocumento11->DOC_ID_Documento = $ID_Documento_T;
            $DestinoDocumento11->Token            = $token; 
            $DestinoDocumento11->NombreDocumento  = $Archivos->getClientOriginalName(); 
            $DestinoDocumento11->Ruta_T           = $codificado;    
            $DestinoDocumento11->save(); 
     
            $DocumentoFirma11                  = new DocumentoFirma11;
            $DocumentoFirma11->ID_Funcionario  = $ID_Funcionario;
            $DocumentoFirma11->ID_Documento    = $DestinoDocumento11->ID_DestinoDocumento;  
            $DocumentoFirma11->Firmado         = 0;  
            $DocumentoFirma11->save();

            $DocumentoFirma112                  = new DocumentoFirma11;
            $DocumentoFirma112->ID_Funcionario  = $this->SelecID_Funcionario_T;
            $DocumentoFirma112->ID_Documento    = $DestinoDocumento11->ID_DestinoDocumento;  
            $DocumentoFirma112->Firmado         = 0;  
            $DocumentoFirma112->save();

            $contenido='sgd.municipalidadcurico.cl/MostrarDocumentoQR/'.$DestinoDocumento11->ID_DestinoDocumento.'/'.$token.'';
    
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
             
            $pdf->Output('F', 'PDF/'.$codificado);

            Storage::disk('QR')->delete($NuevaRuta2);
                
        }
    
        $this->Pagina = 1;      

        session()->flash('message', 'Nueva solicitud 1A1 ingresada correctamente..');      
          
    }

    //Crear imagen firma  
    public $Rut;
    public $Nombres;
    public $Apellidos; 
    public $Oficina;
    public $Cargo;
    public $Existe=0;
    public $Creado=1;

    public function Creada(){

        $this->Creado = 0;  

    }












    public $Materia;

    public $Titulo_T;
    public $Acta;



    public $Equipo1;
    public $Equipo2;
    public $Equipo3;
    public $Equipo4;
    public $Equipo5;
    public $Equipo6;
    public $Equipo7;
    public $Equipo8;

    public $Equipo=2;
    public function AgregarEquipo(){

        $this->Equipo += 1;  

    }

    public function RestarEquipo(){

        $this->Equipo -= 1;  

    }


    public $Correo1;
    public $Correo2;
    public $Correo3;
    public $Correo4;
    public $Correo5;
    public $Correo6;
    public $Correo7;
    public $Correo8;
    public $Correo9;

    public $Correo=2;
    public function AgregarCorreo(){

        $this->Correo += 1;  

    }

    public function RestarCorreo(){

        $this->Correo -= 1;  

    }














    public function render()
    {
        $Funcionario  =  Auth::user()->ID_Funcionario_T; 
        
        if(!empty($this->SelecID_Funcionario_T)){ 
           
                $ExisteFirma=DB::table('ImagenFirma')->Select('id_Funcionario_T')->where('id_Funcionario_T','=', $this->SelecID_Funcionario_T)->first();

                if(empty($ExisteFirma)){ 

                    $DatosFirma =  DB::table('Funcionarios')
                    ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
                    ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
                    ->select('Rut','Nombres','Apellidos','Nombre_DepDir','Cargo','ID_DepDir')->where('ID_Funcionario_T', '=',$this->SelecID_Funcionario_T)->first();

                    $this->Rut = $DatosFirma->Rut;
                    $this->Nombres = $DatosFirma->Nombres;
                    $this->Apellidos = $DatosFirma->Apellidos;  
                    $this->Oficina = $DatosFirma->Nombre_DepDir;
                    $this->Cargo = $DatosFirma->Cargo;

                    $this->Existe = 1;

                }
        }
 
  
        return view('livewire.solicitudes.crear-solicitud',[
            'plantillas' =>  DB::table('plantillas')->get(), 
            
            'ListaFuncionarios' =>  DB::table('Funcionarios') 
            ->where(function($query) { 
                $query->orwhere('Rut', 'like', "%{$this->search}%") 
                ->orwhere('Nombres', 'like', "%{$this->search}%")
                ->orwhere('Apellidos', 'like', "%{$this->search}%");
            }) 
            ->where('ID_Funcionario_T', '!=', $Funcionario)
            ->take(4)->get(),

      ]);
    }
}
 