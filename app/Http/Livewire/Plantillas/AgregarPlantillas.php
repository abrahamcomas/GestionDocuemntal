<?php

namespace App\Http\Livewire\Plantillas; 

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Livewire\WithPagination;
use App\Models\MPlantillas;
use Illuminate\Support\Facades\Storage; 
use Livewire\WithFileUploads; 

class AgregarPlantillas extends Component
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
 
    public function EliminarPlantillas($id_plantillas)
    {   

        $plantillas =  DB::table('plantillas')->select('Ruta_T')->where('id_plantillas', '=', $id_plantillas)->first(); 
        
        $Ruta_T = $plantillas->Ruta_T;

        $codificado = Storage::disk('WORD')->delete($Ruta_T);
                
        $MPlantillas                   = MPlantillas::find($id_plantillas);
        $MPlantillas->delete();

        $Resultado='Plantilla eliminada correctamente.';
      
    }

    public $word; 

    protected $rules = ['word' => 'required']; 
    protected $messages = [ 'word.required' =>'El campo "word" es obligatorio.'];


    public function IngresarPalntilla(){
        
        $this->validate($this->rules,$this->messages); 

        $codificado = Storage::disk('WORD')->put('', $this->word);

        $DestinoDocumento                   = new MPlantillas;
        $DestinoDocumento->nombre_plantilla  = $this->word->getClientOriginalName(); 
        $DestinoDocumento->Ruta_T           = $codificado;   
        $DestinoDocumento->save();  

    } 

    protected $paginationTheme = 'bootstrap';  
    public function render() 
    {  

      

        return view('livewire.plantillas.agregar-plantillas',[
            'plantillas' =>  DB::table('plantillas') 
            ->where(function($query) { 
                    $query->orwhere('nombre_plantilla', 'like', "%{$this->search}%");
            })->paginate($this->perPage), 
      ]);
    }
}
