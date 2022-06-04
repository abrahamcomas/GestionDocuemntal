<?php

namespace App\Http\Livewire\Funcionarios;

use Livewire\Component; 
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\FuncionarioModels;
use App\Models\LugarDeTrabajo;
use Illuminate\Support\Facades\Auth;  

class ListaFuncionarios extends Component
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
  
    public function Desactivar($ID_Funcionario_T){

        $sessiones = DB::table('sessions')
        ->where('user_id', $ID_Funcionario_T)
        ->delete();

        $FuncionarioModels          = FuncionarioModels::find($ID_Funcionario_T);
        $FuncionarioModels->Activo  = 2;
        $FuncionarioModels->save();

        $LugarDeTrabajo             = LugarDeTrabajo::where('ID_Funcionario_LDT',$ID_Funcionario_T)->first();
        $LugarDeTrabajo->Estado_LDT = 2;
        $LugarDeTrabajo->save();

    }

    public function Activar($ID_Funcionario_T){


        $FuncionarioModels          = FuncionarioModels::find($ID_Funcionario_T);
        $FuncionarioModels->Activo  = 1;
        $FuncionarioModels->save(); 

        $LugarDeTrabajo          = LugarDeTrabajo::where('ID_Funcionario_LDT',$ID_Funcionario_T)->first();
        $LugarDeTrabajo->Estado_LDT  = 1;
        $LugarDeTrabajo->save();

    }

    public $ListaFuncionariosOP;
    public $MostrarPagina=1;
    public $mostrar=0;
    protected $paginationTheme = 'bootstrap'; 
    public function render() 
    {

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $VerDisponibilidad =  DB::table('OficinaPartes')
        ->where('id_Funcionario_OP', '=',$ID_Funcionario) 
        ->first();

        if($VerDisponibilidad->Original!=1){
            $this->MostrarPagina = 0;
        }
        else{

            $OficinaPartes =  DB::table('OficinaPartes')
            ->select('Id_OP','ID_OP_LDT','ID_Jefatura')
            ->where('id_Funcionario_OP', '=', $ID_Funcionario)
            ->where('Original', '=', 1)->first(); 
    

            $this->ListaFuncionariosOP =  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->where('Funcionarios.ID_Funcionario_T', '!=', $ID_Funcionario)
            ->where('ID_DepDirecciones_LDT', '=', $OficinaPartes->ID_OP_LDT)->get();
            $this->mostrar=1;


        }

        return view('livewire.funcionarios.lista-funcionarios',[
            'Lista' =>  DB::table('Funcionarios') 
                ->leftjoin('ImagenFirma', 'Funcionarios.ID_Funcionario_T', '=', 'ImagenFirma.id_Funcionario_T') 
            ->paginate(10),
        ]);
    }
}
