<?php

namespace App\Http\Livewire\Root;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\FuncionarioModels; 
use Illuminate\Support\Facades\Auth; 

class DesactivarUsuario extends Component
{

    use WithPagination;  

    public $Ayuda=0;  
    public $search; 
    public $perPage = 5;
    
    public function Ayuda(){ 
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }


    public $Detalles=0; 

    public function clear() 
    {
      $this->search=''; 
      $this->perPage='5';
    }   
 
   
    public function Activo($ID_Funcionario_T){ 

        $Activo =  DB::table('Funcionarios')->select('Activo')->where('id_Funcionario_T', '=',$ID_Funcionario_T)->first();


        if($Activo->Activo==0){
             
            $FuncionarioModels =FuncionarioModels::find($ID_Funcionario_T);
            $FuncionarioModels->Activo               = 1;
            $FuncionarioModels->save();
 
        }else{
            
            $FuncionarioModels =FuncionarioModels::find($ID_Funcionario_T);
            $FuncionarioModels->Activo               = 0;
            $FuncionarioModels->save();

            $sessions =  DB::table('sessions')->where('user_id', '=',$ID_Funcionario_T)->delete();
        }

    }



    public function Volver()
    {
 
        $this->Detalles=0;                    
   
    }    
 
    protected $paginationTheme = 'bootstrap';   
    public function render()
    {

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

        return view('livewire.root.desactivar-usuario',[
            'Lista' =>  DB::table('Funcionarios')
                ->where(function($query) { 
                    $query->orwhere('Rut', 'like', "%{$this->search}%")
                    ->orwhere('Nombres', 'like', "%{$this->search}%")
                    ->orwhere('Apellidos', 'like', "%{$this->search}%");
              }) 
              ->where('ID_Funcionario_T', '!=',$ID_Funcionario)
            ->paginate($this->perPage), 
      ]);
    }
}
 