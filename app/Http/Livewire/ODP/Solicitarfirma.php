<?php

namespace App\Http\Livewire\ODP;

use Livewire\Component;

class Solicitarfirma extends Component
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
        return view('livewire.o-d-p.solicitarfirma');
    }
}
 