<?php

namespace App\Http\Livewire\CKEditor;

use Livewire\Component;
use Livewire\WithPagination; 
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\DB;  
class ListaPlantillas extends Component
{

    use WithPagination;  
    use WithFileUploads; 
    public $search; 
    public $perPage = 5;
    public $Listado;

    public function clear()
    {
      $this->search='';
      $this->perPage='5';
    }

    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
        return view('livewire.c-k-editor.lista-plantillas',[
            'plantillas' =>  DB::table('PlantillasCredas')    
            ->where(function($query) {   
                $query->orwhere('nombre_plantilla', 'like', "%{$this->search}%");
            })   
            ->paginate($this->perPage), 
        ]);
    }
}
 