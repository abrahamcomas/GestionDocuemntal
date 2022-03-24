<?php

namespace App\Http\Livewire\DocumentoExterno;

use Livewire\Component; 
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage; 
use App\Models\DocumentosExterno;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;

class DocumentoExterno extends Component
{
    use WithFileUploads; 

    public $PDF;
    public $Ruta;
    public $x; 
    public $y;

    public $cuantos;
    public $nuevaHora; 

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
        return view('livewire.documento-externo.documento-externo');
    }
}
