<?php

namespace App\Http\Livewire\EncargadoOdp;

use Livewire\Component;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage; 
use App\Models\DocumentosExterno;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;

class FirmaIndividual extends Component
{
    use WithFileUploads; 

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
        return view('livewire.encargado-odp.firma-individual');
    }
}
 