<?php

namespace App\Http\Livewire\Root;

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Livewire\WithPagination;
use App\Models\DepDirecciones;
use Illuminate\Support\Facades\Storage; 
use Livewire\WithFileUploads; 


class DirDep extends Component
{

    
    use WithPagination;   
    use WithFileUploads;

    public $search;  
    public $perPage = 5;
 
    public function clear()
    {
      $this->search='';
      $this->perPage='5';
    }

    public $Estado = 0;
    public function Volver()
    {
      $this->Estado=0;
    } 

    public function Desabilitar($ID_DepDir)
    {   
      
        $DepDirecciones                = DepDirecciones::find($ID_DepDir);
        $DepDirecciones->EstadoDirDep = 0;
        $DepDirecciones->save();

        $this->Estado= 0;

        session()->flash('message1', 'Departamento o dirección desabilitada.');  
      
    }
  
    public function Habilitar($ID_DepDir)
    {   
      
        $DepDirecciones                = DepDirecciones::find($ID_DepDir);
        $DepDirecciones->EstadoDirDep = 1;
        $DepDirecciones->save();

        $this->Estado= 0;
 
        session()->flash('message1', 'Departamento o dirección habilitada.');  
      
    }


    public $NombreEditado;
    public $SeleccionadoID_DepDir;
    public function Editar($ID_DepDir)
    {   
    
        $DepDirecciones =  DB::table('DepDirecciones')
        ->select('Nombre_DepDir')
        ->where('ID_DepDir', '=',$ID_DepDir)->first();

        $this->NombreEditado= $DepDirecciones->Nombre_DepDir;
        $this->SeleccionadoID_DepDir= $ID_DepDir;
        $this->Estado= 1;
    }

    public $NombreNuevo;

    protected $rules1 = ['NombreNuevo' => 'required']; 
    protected $messages1 = [ 'NombreNuevo.required' =>'El campo "Actualizar" es obligatorio.'];

    public function ConfirmarEditar()
    {   
        $this->validate($this->rules1,$this->messages1); 

        $DepDirecciones                = DepDirecciones::find($this->SeleccionadoID_DepDir);
        $DepDirecciones->Nombre_DepDir = $this->NombreNuevo;
        $DepDirecciones->save();

        $this->Estado= 0;
        $this->NombreNuevo= "";

        session()->flash('message1', 'Departamento o dirección actualizada.');  
      
    }

    public $Nombre; 

    protected $rules = ['Nombre' => 'required']; 
    protected $messages = [ 'Nombre.required' =>'El campo "Nombre" es obligatorio.'];

    public function Ingresar(){
        
        $this->validate(); 
 
        $DepDirecciones =  DB::table('DepDirecciones')
        ->select('Nombre_DepDir')
        ->where('Nombre_DepDir', '=',$this->Nombre)->count();
 
 
        if($DepDirecciones==0){
 
            $DepDirecciones                   = new DepDirecciones;
            $DepDirecciones->Nombre_DepDir    = $this->Nombre;  
            $DepDirecciones->save();  
    
            $this->Nombre="";

            session()->flash('message1', 'Departamento o dirección ingresada.');  
        
        }else{ 
            
            session()->flash('message1','Departamento o dirección ingresada anteriormente.');
        } 
    } 
    protected $paginationTheme = 'bootstrap';  
    public function render()
    {
        return view('livewire.root.dir-dep',[
            'DepDirecciones' =>  DB::table('DepDirecciones') 
            ->where(function($query) { 
                    $query->orwhere('Nombre_DepDir', 'like', "%{$this->search}%");
            })->paginate($this->perPage), 
      ]);
    }
}
