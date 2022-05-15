<?php

namespace App\Http\Livewire\Root;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\OficinaPartes;
use App\Models\HistorialOficinaPartes;
use App\Models\FuncionarioModels;
use App\Models\LugarDeTrabajo;
use Illuminate\Support\Facades\Auth; 

class AgregarSecretaria extends Component
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

    public $BuscarNombre; 

    public $ID_DepDir;
    public $BuscarLista=0;  

    public $JefeActual; 
    public function OficinaPartesSeleccionada($ID_DepDir){

        $NombreOficinaParte =  DB::table('DepDirecciones')
        ->leftjoin('OficinaPartes', 'DepDirecciones.ID_DepDir', '=', 'OficinaPartes.ID_OP_LDT')
        ->select('Nombre_DepDir')
        ->where('ID_DepDir', '=', $ID_DepDir)->first();

        $this->ID_DepDir = $ID_DepDir;
        $this->NombreOficinaParte=$NombreOficinaParte->Nombre_DepDir;
       
        $this->BuscarOficinaPartes = "";
        $this->BuscarLista = 1;

    }

    public function NombreSeleccionado($ID_DepDir){

        $NombreOficinaParte =  DB::table('DepDirecciones')
        ->leftjoin('OficinaPartes', 'DepDirecciones.ID_DepDir', '=', 'OficinaPartes.ID_OP_LDT')
        ->select('Nombre_DepDir')
        ->where('ID_DepDir', '=', $ID_DepDir)->first();

        $this->ID_DepDir = $ID_DepDir;
        $this->NombreOficinaParte=$NombreOficinaParte->Nombre_DepDir;
       
        $this->BuscarNombre = "";
        $this->BuscarLista = 1;

    }





    public function Volver(){

        $this->BuscarLista = 0;
        $this->ID_DepDir = 0;
        $this->NombreOficinaParte="";
    }

  
    public function SeleccionarSecretaria($ID_Funcionario_T){

        $OficinaPartes =  DB::table('OficinaPartes')
        ->select('Id_OP','ID_OP_LDT','id_Funcionario_OP','id_Funcionario_OP')
        ->where('ID_OP_LDT', '=', $this->ID_DepDir)->first();

        $Id_OP = $OficinaPartes->Id_OP; 
        $ID_OP_LDT = $OficinaPartes->ID_OP_LDT; 
        $SecretariaActual = $OficinaPartes->id_Funcionario_OP; 

        $SecretariaAnt  =  DB::table('OficinaPartes')
        ->select('id_Funcionario_OP')
        ->where('Id_OP', '=', $Id_OP)->first();

        if(!empty($SecretariaAnt->id_Funcionario_OP)){ 

        $SecretariaFunc          = FuncionarioModels::find($SecretariaAnt->id_Funcionario_OP);
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
        $HistorialOficinaPartes->save();

        $this->mostrar=2;

    }   
 
    public $OficinaPartes;
    public $JefeNombre;
    public $JefeApellido;
    public $ListaFuncionariosOP;

    
    public $SecretariaNombre;
    public $SecretariaApellido;




    public $CambiarBusqueda=0;
    public $BuscarFuncionarios;

    public function CambiarBusqueda(){
        
        if($this->CambiarBusqueda==0){
            
            $this->CambiarBusqueda=1;
            $this->BuscarOficinaPartes = "";
            $this->BuscarNombre = "";
            $this->BuscarLista = 0;
        }
        else{
            
            $this->CambiarBusqueda=0;
            $this->BuscarOficinaPartes = "";
            $this->BuscarNombre = "";
            $this->BuscarLista = 0;
        }

    }
    public $BFuncionarios;

    protected $paginationTheme = 'bootstrap'; 

    public function render()
    {

        $this->OficinaPartes =  DB::table('DepDirecciones')
        ->leftjoin('OficinaPartes', 'DepDirecciones.ID_DepDir', '=', 'OficinaPartes.ID_OP_LDT')
        ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T')
        ->where('Nombre_DepDir', 'like', "%{$this->BuscarOficinaPartes}%")->take(3)->get();

        $this->BFuncionarios =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir')
        ->where(function($query) {  
            $query->orwhere('Nombres','like', "%{$this->BuscarNombre}%")
                ->orwhere('Apellidos','like', "%{$this->BuscarNombre}%");
        })->take(3)->get();



        if($this->BuscarLista!=0){
            $this->ListaFuncionariosOP =  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->where('ID_DepDirecciones_LDT', '=', $this->ID_DepDir)->get();

        } 
 
        if($this->ID_DepDir!=null){  
       
            $Secretaria =  DB::table('OficinaPartes') 
            ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T')
            ->where('ID_OP_LDT', '=', $this->ID_DepDir)->first();
            
            if($Secretaria!=null){
                $this->SecretariaNombre = $Secretaria->Nombres;
                $this->SecretariaApellido=$Secretaria->Apellidos;
            }
            else{
                $this->SecretariaNombre = '"No ';
                $this->SecretariaApellido='seleccionado"';
            }
        }  

        return view('livewire.root.agregar-secretaria',[
            'Lista' =>  DB::table('Funcionarios') 
                ->leftjoin('ImagenFirma', 'Funcionarios.ID_Funcionario_T', '=', 'ImagenFirma.id_Funcionario_T') 
                ->where(function($query) { 
                    $query->orwhere('Rut', 'like', "%{$this->search}%");
              }) 
            ->paginate(10),
        ]);
    }
}
 