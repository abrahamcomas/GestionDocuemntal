<?php

namespace App\Http\Livewire\Portafolio;

use Livewire\Component;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Auth;

class FirmaDetenidoIndividual extends Component
{

    public $PDF; 
    public $Ruta;
    public $x;
    public $y; 

    protected $rules = ['PDF' => 'required']; 

    protected $messages = [ 'PDF.required' =>'El campo PDF es obligatorio.'];

 
    public function Ingresar()
    {  
        $this->validate();  
            
        $Funcionario  =  Auth::user()->ID_Funcionario_T;
        
        $codificado = Storage::disk('PDF')->put('', $this->PDF);

    } 

    public function render()
    {
        return view('livewire.portafolio.firma-detenido-individual');
    }
}
 