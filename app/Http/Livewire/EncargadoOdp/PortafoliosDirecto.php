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

            $LinkFirma =LinkFirma::find($Link->ID_LinkFirma);
            $Portafolio->Estado     = 33;
            $LinkFirma->delete();   
                 
            $this->ObservacionPortafolio="";
            $this->Detalles=0;

        session()->flash('message1', 'Portafolio rechazado.');
      
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
            ->where('Encargado', '=', 1)         
            ->where('IPF_ID_Funcionario', '=', $ID_Funcionario)
            ->orderBy('IPF_ID', 'asc')   
            ->get(),
        
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
