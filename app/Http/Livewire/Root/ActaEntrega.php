<?php

namespace App\Http\Livewire\Root;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\FuncionarioModels; 

class ActaEntrega extends Component
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

    public function Select($ID_Documento_T){  

        $FirmaMasiva =  DB::table('Funcionarios')->select('Acta')->where('id_Funcionario_T', '=',$ID_Documento_T)->first();


        if($FirmaMasiva->Acta==0){
            
            $FuncionarioModels =FuncionarioModels::find($ID_Documento_T);
            $FuncionarioModels->Acta               = 1;
            $FuncionarioModels->save();

        }else{
            
            $FuncionarioModels =FuncionarioModels::find($ID_Documento_T);
            $FuncionarioModels->Acta               = 0;
            $FuncionarioModels->save();

        }
      

    }

    protected $paginationTheme = 'bootstrap';  
    public function render()
    { 
        return view('livewire.root.acta-entrega',[
            'Lista' =>  DB::table('Funcionarios')
                ->where(function($query) { 
                    $query->orwhere('Rut', 'like', "%{$this->search}%")
                    ->orwhere('Nombres', 'like', "%{$this->search}%")
                    ->orwhere('Apellidos', 'like', "%{$this->search}%");
              }) 
            ->paginate($this->perPage), 
      ]);
    }
}
 