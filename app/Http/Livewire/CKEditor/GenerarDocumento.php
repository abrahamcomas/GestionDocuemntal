<?php

namespace App\Http\Livewire\CKEditor;

use Livewire\Component;
use Illuminate\Support\Facades\DB;  
class GenerarDocumento extends Component 
{
    
    public $Plantilla;
    public function render()
    {
        return view('livewire.c-k-editor.generar-documento',[

           
            'plantillas' =>  DB::table('PlantillasCredas')->get(), 
      ]);
    }
}
 