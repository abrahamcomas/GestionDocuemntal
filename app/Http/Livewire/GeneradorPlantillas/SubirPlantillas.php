<?php

namespace App\Http\Livewire\GeneradorPlantillas;

use Livewire\Component;
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Auth; 
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentosExterno;  
use App\Models\DocumentosZip;  
use App\Models\MPlantillas;

class SubirPlantillas extends Component
{

    use WithFileUploads;  
 
 

    public $PDF;
    public $Subido=0; 
    public $Ruta;

    protected $RulesRevision = ['PDF' => 'required'];
	protected $RelusMessagesRevision2 = ['PDF.required' =>'El campo PDF es obligatorio.'];

    public function SubirArchivo(){ 

        $this->validate($this->RulesRevision,$this->RelusMessagesRevision2); 

        $codificado = Storage::disk('WORD')->put('', $this->PDF);

        $DestinoDocumento                   = new MPlantillas;
        $DestinoDocumento->nombre_plantilla = $this->PDF->getClientOriginalName(); 
        $DestinoDocumento->Ruta_T           = $codificado;   
        $DestinoDocumento->save(); 
 
        $this->Ruta =  $DestinoDocumento->Ruta_T;

        $this->Subido = 1;   

            
    }


    public function render()
    {
        return view('livewire.generador-plantillas.subir-plantillas');
    }
}
 