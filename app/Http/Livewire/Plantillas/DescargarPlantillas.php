<?php

namespace App\Http\Livewire\Plantillas;

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Livewire\WithPagination;
use App\Models\MPlantillas;
use Illuminate\Support\Facades\Storage; 
use Livewire\WithFileUploads; 

class DescargarPlantillas extends Component
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


    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
        return view('livewire.plantillas.descargar-plantillas',[
            'plantillas' =>  DB::table('plantillas') 
            ->where(function($query) { 
                    $query->orwhere('nombre_plantilla', 'like', "%{$this->search}%");
            })->paginate($this->perPage), 
      ]);
    }
}
