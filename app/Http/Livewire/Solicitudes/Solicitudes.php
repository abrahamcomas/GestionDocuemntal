<?php

namespace App\Http\Livewire\Solicitudes;

use Livewire\Component;
use Livewire\WithPagination; 
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\Portafolio11;
use App\Models\DocumentoFirma11; 
use Illuminate\Support\Facades\Storage;
use App\Models\DestinoDocumento11;
use App\Models\Documento;
use App\Models\LinkFirma11;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarLink11;   
use setasign\Fpdi\Fpdi;

class Solicitudes extends Component
{

    use WithPagination;  
    use WithFileUploads; 
    public $search;  
    public $perPage = 5;
    public $Ayuda=0; 
    
    public function Ayuda(){
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    } 

    public $EliminarPortafolio;
    public function EliminarPortafolio($ID_Documento_T){ 

        $this->EliminarPortafolio = $ID_Documento_T;
      
        $this->Detalles=3;

    }
 
    public $ContraseniaPortafolio;
    protected $EliminarFirmante = ['ContraseniaPortafolio' => 'required'];
    protected $MensajeEliminarFirmante = ['ContraseniaPortafolio.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    public function EliminarPortafolioConf(){

        $this->validate($this->EliminarFirmante,$this->MensajeEliminarFirmante); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaPortafolio], true)){ 
            
            $ID_OficinaPartes =  DB::table('Portafolio11') 
            ->leftjoin('DestinoDocumento11', 'Portafolio11.ID_Documento_T', '=', 'DestinoDocumento11.DOC_ID_Documento')
            ->select('Ruta_T')
            ->where('DOC_ID_Documento', '=',$this->EliminarPortafolio)
            ->first();
    
         
     
                $codificado = Storage::disk('PDF11')->delete($ID_OficinaPartes->Ruta_T);
                $codificado = Storage::disk('ImagenPDF11')->delete($ID_OficinaPartes->Ruta_T);
    
                
 
            $VistoBueno =Portafolio11::find($this->EliminarPortafolio);
            $VistoBueno->delete();  


            $LinkFirma =  DB::table('LinkFirma11') 
            ->select('ID_LinkFirma')
            ->where('ID_Documento_L', '=',$this->EliminarPortafolio)
            ->get();
    
            foreach ($LinkFirma as $Link) {  
     
                $LinkFirma =LinkFirma11::find($Link->ID_LinkFirma);
                $LinkFirma->delete();   
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

    //Pagina principal  
    public $Detalles=0;
    public $ID_Documento_T;
 
    public $Per_Subir;
    
    public $FuncionarioSelec;
  

    public function EnviarDocumento($ID_Documento_T,$ID_Funcionario){

        $this->FuncionarioSelec=$ID_Funcionario;
        $this->ID_Documento_T=$ID_Documento_T;
        $this->Detalles=2;
                 
    } 
 
    public function EnviarCorreo($ID_LinkFirma){

        $DatosEmisor=DB::table('LinkFirma11')->Select('Titulo_T','Nombres_L','Apellidos_L','Contenido','direccionEmail')->where('ID_LinkFirma','=', $ID_LinkFirma)->first();
 
        $Titulo = $DatosEmisor->Titulo_T; 
        $Nombres = $DatosEmisor->Nombres_L.' '.$DatosEmisor->Apellidos_L; 
        $Contenido = $DatosEmisor->Contenido; 
        $Email = $DatosEmisor->direccionEmail;  
    
        Mail::to($Email)->send(new EnviarLink11($Titulo,$Nombres,$Contenido,$Email)); 

        $LinkFirma =LinkFirma11::find($ID_LinkFirma);
        $LinkFirma->Email = 1;
        $LinkFirma->save();  

    } 

    public function VolverPrincipal(){
        $this->Detalles=0;
        $this->resetPage();  
        $this->resetErrorBag();  
    }

    public function clear()
    {
      $this->search='';
      $this->perPage='5';
    }

    public $MensajeRechazo; 
    public $Mostrar=0;
    public function MensajeRechazo($ID_Documento_T){

        $ObservacionE =  DB::table('InterPortaFuncionario')
        ->select('ObservacionE')
        ->where('IPF_Portafolio', '=',$ID_Documento_T)->first();

        $this->MensajeRechazo = $ObservacionE->ObservacionE;


        $this->Mostrar=1; 


    }

    public $Funcionarios;
    public $NombreEncargado;
    public $ApellidoEncargado;
  
    public $Lista=0;
    
    public $BusquedaDetenido=0;
    public $BusquedaEsperando=1;
    public $BusquedaFinalizados=0;
    protected $paginationTheme = 'bootstrap'; 

    public function render()
    { 

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;  

        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->select('ID_DepDirecciones_LDT')
        ->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

        $ID_DepDir = $DatosFirma->ID_DepDirecciones_LDT;

        $DatosEncargado =  DB::table('OficinaPartes') 
        ->leftjoin('Funcionarios', 'OficinaPartes.ID_Jefatura', '=', 'Funcionarios.ID_Funcionario_T') 
        ->select("ID_Funcionario_T","Nombres","Apellidos","Id_OP")->where('ID_OP_LDT', '=',$ID_DepDir)
        ->first();

        $Id_OP = $DatosEncargado->Id_OP;
        $this->NombreEncargado = $DatosEncargado->Nombres;
        $this->ApellidoEncargado = $DatosEncargado->Apellidos;

        if($this->Lista!=0){
            $this->BusquedaDetenido=2;
            $this->BusquedaEsperando=2;
            $this->BusquedaFinalizados=2;
        }
        else{
            $this->BusquedaDetenido=0;
            $this->BusquedaEsperando=1;
            $this->BusquedaFinalizados=0;
        }

        return view('livewire.solicitudes.solicitudes',[
            'posts' =>  DB::table('Portafolio11') 
                ->leftjoin('Funcionarios', 'Portafolio11.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T') 
                ->where(function($query) {  
                    $query->orwhere('Estado_T', '=', $this->BusquedaDetenido)
                            ->orwhere('Estado_T', '=', $this->BusquedaEsperando)
                            ->orwhere('Estado_T', '=', $this->BusquedaFinalizados);
                    })     
                ->where(function($query) {  
                    $query->orwhere('Titulo_T', 'like', "%{$this->search}%");
                    })         
                ->where('ID_Funcionario_Sol', '=', $ID_Funcionario)->orderBy('Estado_T', 'asc')    
                ->paginate($this->perPage),
            
                'MostrarDocumentos' =>  DB::table('DestinoDocumento11') 
                ->leftjoin('DocumentoFirma11', 'DestinoDocumento11.ID_DestinoDocumento', '=', 'DocumentoFirma11.ID_Documento')
                ->select('ID_FSube','ID_DestinoDocumento','NombreDocumento','ID_DocumentoFirma','ID_Documento','FechaFirma','Firmado')
                ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
                ->where('ID_Funcionario', '=',$this->FuncionarioSelec)->paginate(4),
    
                'LinkFirma' =>  DB::table('LinkFirma11')
                ->select('ID_LinkFirma','ID_Funcionario_L','Nombres_L','Apellidos_L','Contenido','Estado','Email','direccionEmail')
                ->where('ID_Documento_L', '=', $this->ID_Documento_T)
                ->get(),
    
            ]);
    }
}
