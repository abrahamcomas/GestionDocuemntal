<?php

namespace App\Http\Livewire\Portafolio;

use Livewire\Component;
use Livewire\WithPagination; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\InterPortaFuncionarioVB;


class RecibidosVB extends Component
{ 
    public $Ayuda=0; 
    
    public function Ayuda(){
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }
    
    public $ID_Documento_T;
    public $Detalles=0;
    public $IPFVB;
     
    public function Detalles($ID_Documento_T)
    {
     

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 


        $ID =  DB::table('Portafolio')
        ->leftjoin('InterPortaFuncionarioVB', 'Portafolio.ID_Documento_T', '=', 'InterPortaFuncionarioVB.IPF_Portafolio') 
        ->select('IPFVB') 
        ->where('IPF_ID_Funcionario', '=',  $ID_Funcionario)
        ->where('IPF_Portafolio', '=',  $ID_Documento_T)->first();

        $InterPortaFuncionario         =InterPortaFuncionarioVB::find($ID->IPFVB);
        $InterPortaFuncionario->Visto  = 1;
        $InterPortaFuncionario->save(); 

        $this->Detalles=1;
        $this->ID_Documento_T=$ID_Documento_T;
        $this->IPFVB=$ID->IPFVB;

    }
 
    use WithPagination;  
    public $search; 
    public $perPage = 5;
   
    public function clear()
    {
        $this->search='';
        $this->perPage=5;
    }
 
    public function Volver(){

        $this->Detalles=0;
    } 
    
    public $Cambiar=0;
 
    public function CambiarVB()
    {
      $this->Cambiar=1;  
    }

    public function CambiarFirmantes()
    {
      $this->Cambiar=0; 
    }
 
    public $BuscarOficinaPartes=""; 
    public $NombreOficinaParte;
    public $Id_OP_Receptor;
    public $ID_DepDir=0;

    public function OficinaPartesSeleccionada($ID_DepDir){

        $NombreOficinaParte =  DB::table('DepDirecciones')
        ->select('Nombre_DepDir')
        ->where('ID_DepDir', '=', $ID_DepDir)->first();

        $this->NombreOficinaParte=$NombreOficinaParte->Nombre_DepDir;

        $this->ID_DepDir = $ID_DepDir;
        $this->BuscarOficinaPartes = "";

    }
    public function VolverPrincipal(){
        $this->Detalles=0;
        $this->resetPage(); 
        $this->resetErrorBag(); 
    }

    public $TipoRespuesta;  
    public $ObservacionPortafolio;
    public function RespuestaPortafolio(){

        $this->ID_Documento_T; 
    
        if($this->TipoRespuesta==1){ 
            
            $InterPortaFuncionarioVB                        =InterPortaFuncionarioVB::find($this->IPFVB);
            $InterPortaFuncionarioVB->Estado                = $this->TipoRespuesta;
            $InterPortaFuncionarioVB->ObservacionResp       = $this->ObservacionPortafolio;
            $InterPortaFuncionarioVB->save(); 
                
            $this->TipoRespuesta="";
            $this->ObservacionPortafolio="";
            $this->Detalles=0;
            session()->flash('message1', 'Solicitud aceptada.');  

        }else{

            $InterPortaFuncionarioVB                        =InterPortaFuncionarioVB::find($this->IPFVB);
            $InterPortaFuncionarioVB->Estado                = $this->TipoRespuesta;
            $InterPortaFuncionarioVB->ObservacionResp       = $this->ObservacionPortafolio;
            $InterPortaFuncionarioVB->save(); 
            
            $this->TipoRespuesta="";
            $this->ObservacionPortafolio="";
            $this->Detalles=0;
            session()->flash('message1', 'Solicitud rechazada.');  

        }
    } 

    public $Funcionarios;
    public $TipoFirma;
    protected $paginationTheme = 'bootstrap'; 

    public function render() 
    {

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->select('ID_DepDir')->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

        $ID_DepDir = $DatosFirma->ID_DepDir;

        return view('livewire.portafolio.recibidos-v-b',[
            'posts' =>  DB::table('Portafolio') 
                ->leftjoin('InterPortaFuncionarioVB', 'Portafolio.ID_Documento_T', '=', 'InterPortaFuncionarioVB.IPF_Portafolio')
                ->leftjoin('OficinaPartes', 'Portafolio.ID_OficinaP', '=', 'OficinaPartes.Id_OP')
                ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
                ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
                ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T') 
                ->where(function($query) {
                $query->orwhere('Estado', '=', 0)
                        ->orwhere('Estado', '=', 1);  
                })
                ->where(function($query) {
                    $query->orwhere('Folio', 'like', "%{$this->search}%")
                            ->orwhere('Titulo_T', 'like', "%{$this->search}%")
                            ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                            ->orwhere('Observacion_T', 'like', "%{$this->search}%"); 
                })  
                ->where('IPF_ID_Funcionario', '=', $ID_Funcionario)     
                ->where('Estado', '=', 0)     
                ->paginate($this->perPage),


                
            'Anio' =>  DB::table('Portafolio') 
                ->select('Anio') 
                ->distinct('Anio')          
                ->get(),
            
            'MostrarDocumentos' =>  DB::table('DestinoDocumento')  
                ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
                ->select('ID_FSube','NombreDocumento','ID_DestinoDocumento','Nombres','Apellidos')
                ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->paginate(4),

            'DestinoFirmantes' =>  DB::table('InterPortaFuncionario') 
                ->leftjoin('Funcionarios', 'InterPortaFuncionario.IPF_ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T') 
                ->where('IPF_Portafolio', '=',$this->ID_Documento_T)   
                ->get(),  

            'VistoBueno' =>  DB::table('InterPortaFuncionarioVB') 
                ->leftjoin('Funcionarios', 'InterPortaFuncionarioVB.IPF_ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
                ->where('IPF_Portafolio', '=',$this->ID_Documento_T) 
                ->get(),

            'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
                ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
                ->select("Nombres","Apellidos")->where('ID_OP_LDT', '=',$ID_DepDir)
                ->first(),
            
            ]);
    } 
}
