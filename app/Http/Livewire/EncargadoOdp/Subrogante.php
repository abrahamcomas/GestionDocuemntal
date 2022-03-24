<?php

namespace App\Http\Livewire\EncargadoOdp; 

use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\SubroganteModels;
use App\Models\FuncionarioModels;
use Livewire\Component;
use Illuminate\Support\Facades\Auth; 

class Subrogante extends Component
{
 
    public $Ayuda=0; 
    
    public function Ayuda(){
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }
    
    use WithPagination;
    public $search; 
    public $perPage = 5;  
    public $Estado = 0;    

    public $FuncionarioSeleccionado; 
    
    public $Rut;
    public $Nombres;  
    public $Apellidos; 
    public $Nombre_DepDir;

    public function VolverPrincipal(){
         
        $this->Estado=0;
        $this->search='';
        $this->perPage=5;
        $this->AnioSelect=date('Y');

    }

    public function VolverFinalizados(){
         
        $this->Estado=3;
        $this->search='';
        $this->perPage=5;
        $this->AnioSelect=date('Y');

    }

    public function VolverHistorial(){

        $this->Estado=5;
        $this->search='';
        $this->perPage=5;
        $this->AnioSelect=date('Y');
    
    }

    public function MostrarLista(){
        
        $this->Estado=5;

    }

    public function Desactivar(){
        
        $this->Estado=2;

    }

    public function ConfirmarDesactivar(){

        $Id_Subrogante_O  =  Auth::user()->ID_Funcionario_T;

        $UltimoActivo =  DB::table('Subrogante')
        ->select('Id_subrogante') 
        ->where('Activo', '=', 1) 
        ->where('Id_Subrogante_O', '=', $Id_Subrogante_O) 
        ->first();

        $Id_Subrogante_O                = FuncionarioModels::find($Id_Subrogante_O);
        $Id_Subrogante_O->Subrogante    = 0;
        $Id_Subrogante_O->save(); 

        if(!empty($UltimoActivo->Id_subrogante)){
            
            $Activo = $UltimoActivo->Id_subrogante; 

            $SecretariaFunc          = SubroganteModels::find($Activo);
            $SecretariaFunc->Activo  = 0;
            $SecretariaFunc->save(); 
        
        }

        $this->Estado=0;

    }
 
    public function Seleccionar($ID_Funcionario_T){

        $this->Estado=1;
        $this->FuncionarioSeleccionado=$ID_Funcionario_T;

        $Datos =  DB::table('Funcionarios') 
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->select('Rut','Nombres', 'Apellidos','Nombre_DepDir') ->first();

        $this->Rut = $Datos->Rut; 
        $this->Nombres = $Datos->Nombres; 
        $this->Apellidos = $Datos->Apellidos;  
        $this->Nombre_DepDir = $Datos->Nombre_DepDir; 

    }

    public function Confirmar(){ 

        $Id_Subrogante_O  =  Auth::user()->ID_Funcionario_T;

        $UltimoActivo =  DB::table('Subrogante')
        ->select('Id_subrogante')
        ->where('Activo', '=', 1) 
        ->where('Id_Subrogante_O', '=', $Id_Subrogante_O) 
        ->first();

        

        if(empty($UltimoActivo->Id_subrogante)){
            
            $Funcionario =  DB::table('Funcionarios')
            ->select('Subrogante')
            ->where('ID_Funcionario_T', '=', $Id_Subrogante_O) 
            ->first();
    
            if($Funcionario->Subrogante==1){
                
                $FuncionarioModels          = FuncionarioModels::find($Id_Subrogante_O);
                $FuncionarioModels->Subrogante  = 0;
                $FuncionarioModels->save(); 
                
    
            }else{ 
    
                $FuncionarioModels          = FuncionarioModels::find($Id_Subrogante_O);
                $FuncionarioModels->Subrogante  = 1;
                $FuncionarioModels->save(); 
    
            }
     
    
            $Subrogante                     = new SubroganteModels;
            $Subrogante->Activo             = 1;
            $Subrogante->Id_Subrogante_S    = $this->FuncionarioSeleccionado;
            $Subrogante->Id_Subrogante_O    = $Id_Subrogante_O;
            $Subrogante->Date_Inicio        = date("Y/m/d");;
            $Subrogante->Date_Final         = date("Y/m/d");;
            $Subrogante->save();
            
            $this->Estado=0;
    
            session()->flash('message', 'Subrogante seleccionado correctamente.');   
        
        }else{
            
            $this->Estado=0;
            session()->flash('message2', 'Subrogante ya seleccionado.');  

        }
        
    }

    public $ID_Documento_T;
    public $Detalles=0;

    public function Detalles($ID_Documento_T)
    {
      $this->Detalles=1;
      $this->ID_Documento_T=$ID_Documento_T;
    }
 
    public $AnioSelect;
   
    public function clear()
    {
        $this->search='';
        $this->perPage=5;
        $this->AnioSelect=date('Y');
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
 
    public $ID_Documento_T_Sel;

    public function MostrarPortafolios($ID_Documento_T){
  
        $this->ID_Documento_T_Sel=$ID_Documento_T;
        $this->Estado=3;

    }

    public function MostrarPortafoliosDetalles($ID_Documento_T)
    {
      $this->Estado=4;
      $this->ID_Documento_T=$ID_Documento_T;
    }

    public $Funcionarios;
    public $TipoFirma;
    protected $paginationTheme = 'bootstrap'; 

    public $SS_Rut;
    public $SS_Nombres;  
    public $SS_Apellidos; 
    public function render()
    {

        if ($this->AnioSelect=='') { 
            $this->AnioSelect=date('y'); 
        }

        $ID_Funcionario_T  =  Auth::user()->ID_Funcionario_T; 


        return view('livewire.encargado-odp.subrogante',[
            'Lista' =>  DB::table('Funcionarios') 
                ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
                ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
                ->select('ID_Funcionario_T','Rut','Nombres', 'Apellidos','Nombre_DepDir') 
                ->where(function($query) { 
                    $query->orwhere('Rut', 'like', "%{$this->search}%")
                    ->orwhere('Nombres', 'like', "%{$this->search}%")
                    ->orwhere('Apellidos', 'like', "%{$this->search}%");
              })  
            ->where('ID_Funcionario_T', '!=', $ID_Funcionario_T)
            ->paginate($this->perPage), 
            'Subrogantes' =>  DB::table('Subrogante') 
            ->leftjoin('Funcionarios', 'Subrogante.Id_Subrogante_S', '=', 'Funcionarios.ID_Funcionario_T') 
            ->leftjoin('IntePortSubrog', 'Subrogante.Id_subrogante', '=', 'IntePortSubrog.Id_subrogante_P') 
            ->select('ID_Funcionario_T','Rut','Nombres', 'Apellidos','ID_Documento_T_P','Date_Inicio','Date_Final') 
            ->where(function($query) { 
                $query->orwhere('Rut', 'like', "%{$this->search}%")
                ->orwhere('Nombres', 'like', "%{$this->search}%")
                ->orwhere('Apellidos', 'like', "%{$this->search}%");
            }) 
            ->where('Id_Subrogante_O', '=', $ID_Funcionario_T)
            ->paginate($this->perPage),

            'SubroganteActual' =>  DB::table('Subrogante') 
            ->leftjoin('Funcionarios', 'Subrogante.Id_Subrogante_S', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select('Rut','Nombres', 'Apellidos') 
            ->where('Id_Subrogante_O', '=', $ID_Funcionario_T)
            ->where('Subrogante.Activo', '=', 1)
            ->get(),  

            'posts' =>  DB::table('Portafolio') 
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->leftjoin('IntePortSubrog', 'Portafolio.ID_Documento_T', '=', 'IntePortSubrog.ID_Documento_T_P')
            ->leftjoin('Subrogante', 'IntePortSubrog.Id_subrogante_P', '=', 'Subrogante.Id_subrogante')
            ->where(function($query) {
                $query->orwhere('Estado_T', '=', 3)
                        ->orwhere('Estado_T', '=', 4);  
                })  
                ->where('Anio','=', $this->AnioSelect)
                ->where(function($query) {
                    $query->orwhere('Folio', 'like', "%{$this->search}%")
                            ->orwhere('Titulo_T', 'like', "%{$this->search}%")
                          ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                          ->orwhere('Observacion_T', 'like', "%{$this->search}%"); 
            })  
            ->where('Id_Subrogante_O', '=', $ID_Funcionario_T)     
            ->paginate($this->perPage),
            'Anio' =>  DB::table('Portafolio')
            ->select('Anio')
            ->distinct('Anio')          
            ->get(), 
            'DestinoFirmantes' =>  DB::table('DocFunc') 
            ->leftjoin('OficinaPartes', 'DocFunc.ID_OP_R', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->where('ID_Documento', '=',$this->ID_Documento_T)   
            ->get(), 
            'VistoBueno' =>  DB::table('VistoBueno') 
            ->leftjoin('OficinaPartes', 'VistoBueno.ID_OP_R', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->where('ID_Documento', '=',$this->ID_Documento_T) 
            ->get(),
            'MostrarDocumentos' =>  DB::table('DestinoDocumento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
            ->select('ID_FSube','ID_DestinoDocumento','NombreDocumento','ID_DocumentoFirma','ID_Documento','FechaFirma','Firmado')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
            ->where('ID_Funcionario', '=',$this->ID_Documento_T_Sel)->paginate(4),

      ]);
    }
}
 