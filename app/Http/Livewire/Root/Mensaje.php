<?php

namespace App\Http\Livewire\Root;

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Livewire\WithPagination;
use App\Models\TipoDocumento;
use App\Models\MensajeModel;
use Illuminate\Support\Facades\Storage; 

class Mensaje extends Component
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


    public function Eliminar($id_Mensaje)
    {   
      
        $Mensaje            = MensajeModel::find($id_Mensaje);
        $Mensaje->Estado    = 0;
        $Mensaje->delete();

        session()->flash('message1', 'Mensaje eliminado.');  
      
    }


    public $MensajeIngresado; 
    protected $rules1 = ['MensajeIngresado' => 'required']; 
    protected $messages1 = ['MensajeIngresado.required' =>'El campo "Mensaje" es obligatorio.'];

    public function IngresarMensaje() 
    {   
        $this->validate($this->rules1,$this->messages1);  

        $Mensaje =  DB::table('Mensaje')
        ->select('id_Mensaje')
        ->where('Estado', '=',1)->get();

        
        foreach ($Mensaje as $Mens) {  

            $Mensaje            = MensajeModel::find($Mens->id_Mensaje);
            $Mensaje->Estado    = 0;
            $Mensaje->save();

        } 

        $MensajeModel               = new MensajeModel;
        $MensajeModel->Mensaje      = $this->MensajeIngresado;
        $MensajeModel->FechaInicio  = date("Y-m-d");
        $MensajeModel->Estado       = 1;
        $MensajeModel->save();

        $this->MensajeIngresado= "";

        session()->flash('message1', 'Nombre tipo solicitud actualizada.');  
      
    }

    protected $paginationTheme = 'bootstrap';  
    public function render()
    {
        return view('livewire.root.mensaje',[
            'Mensaje' =>  DB::table('Mensaje') 
            ->where(function($query) {  
                    $query ->orwhere('FechaInicio', 'like', "%{$this->search}%")
                            ->orwhere('Mensaje', 'like', "%{$this->search}%");
            })->paginate($this->perPage), 
      ]);
    }
}
 