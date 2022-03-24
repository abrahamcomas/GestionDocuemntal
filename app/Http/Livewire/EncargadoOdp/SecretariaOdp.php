<?php

namespace App\Http\Livewire\EncargadoOdp;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\OficinaPartes;
use App\Models\HistorialOficinaPartes;
use Illuminate\Support\Facades\Auth; 
use App\Models\FuncionarioModels;
use App\Models\LugarDeTrabajo;

class SecretariaOdp extends Component
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
    public $Detalles=0; 
    public $ID_Funcionario_T; 
    public $Nombres;
    public $Apellidos; 
 
    public $BuscarOficinaPartes; 
    public $NombreOficinaParte;

    public $ID_DepDir;

    public $mostrar=1;
   
    public function Volver(){

        $this->mostrar = 1;
    }

    public function SeleccionarSecretaria($ID_Funcionario_T){

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $OficinaPartes =  DB::table('OficinaPartes')
        ->select('Id_OP','ID_OP_LDT','ID_Jefatura','id_Funcionario_OP')
        ->where('ID_Jefatura', '=', $ID_Funcionario)->first();

        $Id_OP = $OficinaPartes->Id_OP; 
        $ID_OP_LDT = $OficinaPartes->ID_OP_LDT; 
        $ID_Jefatura = $OficinaPartes->ID_Jefatura;  
        $SecretariaActual = $OficinaPartes->id_Funcionario_OP; 

        $SecretariaAnt  =  DB::table('Funcionarios')
        ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP')
        ->select('ID_Funcionario_T')
        ->where('Id_OP', '=', $Id_OP)->first();

        if(!empty($SecretariaAnt->ID_Funcionario_T)){ 

        $SecretariaAnt = $SecretariaAnt->ID_Funcionario_T;
        
        
      

        $SecretariaFunc          = FuncionarioModels::find($SecretariaAnt);
        $SecretariaFunc->Secretaria  = 0;
        $SecretariaFunc->save(); 

        }


        $FuncionarioModels          = FuncionarioModels::find($ID_Funcionario_T);
        $FuncionarioModels->Activo  = 1;
        $FuncionarioModels->Secretaria  = 1;
        $FuncionarioModels->save(); 

        $ID_LugarDeTrabajo  =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
        ->select('ID_LugarDeTrabajo')
        ->where('ID_Funcionario_T', '=', $ID_Funcionario_T)->first();

        $FuncionarioModels               = LugarDeTrabajo::find($ID_LugarDeTrabajo->ID_LugarDeTrabajo);
        $FuncionarioModels->Estado_LDT   = 1;
        $FuncionarioModels->save();

        $OficinaPartes                      = OficinaPartes::find($Id_OP);
        $OficinaPartes->id_Funcionario_OP   = $ID_Funcionario_T; 
        $OficinaPartes->save();

        $HistorialOficinaPartes                     = new HistorialOficinaPartes;
        $HistorialOficinaPartes->Id_OP              = $Id_OP;
        $HistorialOficinaPartes->ID_OP_LDT          = $ID_OP_LDT;
        $HistorialOficinaPartes->id_Funcionario_OP  = $ID_Funcionario_T;
        $HistorialOficinaPartes->ID_Jefatura        = $ID_Jefatura;
        $HistorialOficinaPartes->save();

        $this->mostrar=2;

    }   
 
    public $NombreDireccion;
    public $SecretariaNombre;
    public $SecretariaApellido;
    public $ListaFuncionariosOP;

   
    protected $paginationTheme = 'bootstrap'; 

    public $Mensaje;
    public function render()
    {

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $Jefe =  DB::table('OficinaPartes') 
        ->select('id_Funcionario_OP')
        ->where('ID_Jefatura', '=',$ID_Funcionario)
        ->first(); 

        if(empty($Jefe->id_Funcionario_OP)){
            
            $this->Mensaje="Por favor antes de continuar seleccione la secretaria/o que estará a cargo de la ODP.";  
        
        } 

        $OficinaPartes =  DB::table('OficinaPartes')
        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
        ->select('ID_DepDir','Nombre_DepDir')
        ->where('ID_Jefatura', '=', $ID_Funcionario)->first();
        


   

   
                $this->NombreDireccion = $OficinaPartes->Nombre_DepDir;
                $ID_DepDir = $OficinaPartes->ID_DepDir; 
         

              

            $this->ListaFuncionariosOP =  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->where('ID_DepDirecciones_LDT', '=', $ID_DepDir)->get();

            if($ID_DepDir!=null){

                $Secretaria =  DB::table('OficinaPartes') 
                ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T')
              
                ->where('ID_OP_LDT', '=', $ID_DepDir)->first();
    
                if($Secretaria!=null){
                    $this->SecretariaNombre = $Secretaria->Nombres;
                    $this->SecretariaApellido=$Secretaria->Apellidos;
                }
                else{
                    $this->SecretariaNombre = '"No ';
                    $this->SecretariaApellido='seleccionado"';
                }
            } 

       
        return view('livewire.encargado-odp.secretaria-odp',[
            'Lista' =>  DB::table('Funcionarios') 
                ->leftjoin('ImagenFirma', 'Funcionarios.ID_Funcionario_T', '=', 'ImagenFirma.id_Funcionario_T') 
                ->where(function($query) { 
                    $query->orwhere('Rut', 'like', "%{$this->search}%");
              }) 
            ->paginate(10),
        ]);
    }
}
 