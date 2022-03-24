<?php

namespace App\Http\Livewire\Root;

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Livewire\WithPagination;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Storage; 

class Documentos extends Component
{
    use WithPagination;  

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


    public function Desabilitar($ID_TipoDocumento_T)
    {   
      
        $TipoDocumento                          = TipoDocumento::find($ID_TipoDocumento_T);
        $TipoDocumento->EstadoTipoDocumento    = 0;
        $TipoDocumento->save();

        session()->flash('message1', 'Nombre tipo solicitud desabilitada.');  
      
    }

    public function Habilitar($ID_TipoDocumento_T)
    {   
      
        $TipoDocumento                          = TipoDocumento::find($ID_TipoDocumento_T);
        $TipoDocumento->EstadoTipoDocumento    = 1;
        $TipoDocumento->save();

        $this->Estado= 0;
 
        session()->flash('message1', 'Nombre tipo solicitud habilitada.');  
      
    }

    public $NombreEditado;
    public $SeleccionadoID_TipoDocumento_T;
    public function Editar($ID_TipoDocumento_T)
    {   
    
        $TipoDocumento =  DB::table('TipoDocumento')
        ->select('Nombre_T')
        ->where('ID_TipoDocumento_T', '=',$ID_TipoDocumento_T)->first();

        $this->NombreEditado= $TipoDocumento->Nombre_T;
        $this->SeleccionadoID_TipoDocumento_T= $ID_TipoDocumento_T;
        $this->Estado= 1;
    }

    public $NombreNuevo;
    
    protected $rules1 = ['NombreNuevo' => 'required']; 
    protected $messages1 = [ 'NombreNuevo.required' =>'El campo "Actualizar" es obligatorio.'];


    public function ConfirmarEditar()
    {   
        $this->validate($this->rules1,$this->messages1); 

        $TipoDocumento                = TipoDocumento::find($this->SeleccionadoID_TipoDocumento_T);
        $TipoDocumento->Nombre_T      = $this->NombreNuevo;
        $TipoDocumento->save();
 
        $this->Estado= 0;
        $this->NombreNuevo= "";

        session()->flash('message1', 'Nombre tipo solicitud actualizada.');  
      
    }





    public $Nombre; 

    protected $rules = ['Nombre' => 'required']; 
    protected $messages = [ 'Nombre.required' =>'El campo "Nombre" es obligatorio.'];

    public function Ingresar(){
         
        $this->validate(); 
 
        $BuscarNombre =  DB::table('TipoDocumento')
        ->select('Nombre_T')
        ->where('Nombre_T', '=',$this->Nombre)->count();
 

        if($BuscarNombre==0){

            $TipoDocumento                   = new TipoDocumento;
            $TipoDocumento->Nombre_T            = $this->Nombre;  
            $TipoDocumento->save();  
    
            $this->Nombre="";
            
            session()->flash('message1', 'Nombre tipo solicitud ingresada.');  
        
        }else{ 
            
            session()->flash('message1','Nombre tipo solicitud ingresada anteriormente.');
        } 
    } 

    protected $paginationTheme = 'bootstrap';   
    public function render()
    {
        return view('livewire.root.documentos',[
            'TipoDocumento' =>  DB::table('TipoDocumento') 
            ->where(function($query) { 
                    $query->orwhere('Nombre_T', 'like', "%{$this->search}%");
            })->paginate($this->perPage), 
      ]);
    }
}
