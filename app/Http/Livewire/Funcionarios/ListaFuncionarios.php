<?php

namespace App\Http\Livewire\Funcionarios;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\FuncionarioModels;
use App\Models\Roles;
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

    }

    public function Activar($ID_Funcionario_T){

        $sessiones = DB::table('sessions')
        ->where('user_id', $ID_Funcionario_T)
        ->delete();

        $FuncionarioModels          = FuncionarioModels::find($ID_Funcionario_T);
        $FuncionarioModels->Activo  = 1;
        $FuncionarioModels->save();

    }


    public $NombreDireccion;
    public $ListaFuncionariosOP;
    public $mostrar=0;
    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $OficinaPartes =  DB::table('OficinaPartes')
        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
        ->select('ID_DepDir','Nombre_DepDir')
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)->get();
        
        $Numero = count($OficinaPartes);

        if($Numero!=0){

            foreach ($OficinaPartes as $user){
                $this->NombreDireccion = $user->Nombre_DepDir;
                $ID_DepDir = $user->ID_DepDir;
            }
 
               
            $this->ListaFuncionariosOP =  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->where('ID_DepDirecciones_LDT', '=', $ID_DepDir)->get();
            $this->mostrar=1;

        } 

        return view('livewire.funcionarios.lista-funcionarios',[
            'Lista' =>  DB::table('Funcionarios') 
                ->leftjoin('ImagenFirma', 'Funcionarios.ID_Funcionario_T', '=', 'ImagenFirma.id_Funcionario_T') 
            ->paginate(10),
        ]);
    }
}
