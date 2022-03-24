<?php

namespace App\Http\Livewire\Root;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\ImagenFirma;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SubirImagenFirma extends Component
{

    public $Ayuda=0; 
    
    public function Ayuda(){
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }

    
    use WithPagination;  
    use WithFileUploads;
    public $search; 
    public $perPage = 5;

    public $Detalles=0; 
    public $photo;  

    public $ID_Funcionario_T;  

    public function clear()
    {
      $this->search='';
      $this->perPage='5';
    }
 
    public function Agregar($ID_Documento_T){ 

        $this->ID_Funcionario_T=$ID_Documento_T;
        $this->Detalles=1;
    }

    protected $rules2 = [
        'photo' => 'required', 
    ];
 
    protected $messages2 = [
        'photo.required' =>'El campo Foto es obligatorio.',
    ];

    public function IngresoMulta()
    {
        $this->validate($this->rules2,$this->messages2); 

        $Existe =  DB::table('ImagenFirma')->where('id_Funcionario_T', '=',$this->ID_Funcionario_T)->first();

        if(!empty($Existe->id_Funcionario_T)){

         
            if(!empty($this->photo)){ 
                
                $Ruta =  DB::table('Funcionarios')
                    ->leftjoin('ImagenFirma', 'Funcionarios.ID_Funcionario_T', '=', 'ImagenFirma.id_Funcionario_T') 
                    ->where('Funcionarios.ID_Funcionario_T', '=',$this->ID_Funcionario_T)->first();

                $nommbreArchivo = Storage::disk('Firmas')->put('', $this->photo); 

                $ImagenFirma =ImagenFirma::find($Ruta->ID_Imagen);
                $ImagenFirma->id_Funcionario_T  = $this->ID_Funcionario_T;
                $ImagenFirma->Ruta              = $nommbreArchivo;
                $ImagenFirma->save();

                $nommbreArchivo = Storage::disk('Firmas')->delete($Ruta->Ruta); 

                $this->Detalles=2;   
            
            }
        } 
        else{

            if(!empty($this->photo)){  

                $nommbreArchivo = Storage::disk('Firmas')->put('', $this->photo);
                
                $ImagenFirma                    = new ImagenFirma;
                $ImagenFirma->id_Funcionario_T  = $this->ID_Funcionario_T;
                $ImagenFirma->Ruta              = $nommbreArchivo;
                $ImagenFirma->save();

                $this->Detalles=2;     
            
            }
        }               
    }   

    public function Volver()
    {
 
        $this->Detalles=0;                    
   
    }

    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
        return view('livewire.root.subir-imagen-firma',[
            'Lista' =>  DB::table('Funcionarios') 
                ->leftjoin('ImagenFirma', 'Funcionarios.ID_Funcionario_T', '=', 'ImagenFirma.id_Funcionario_T') 
                ->where(function($query) { 
                    $query->orwhere('Rut', 'like', "%{$this->search}%")
                    ->orwhere('Nombres', 'like', "%{$this->search}%")
                    ->orwhere('Apellidos', 'like', "%{$this->search}%");
              }) 
            ->paginate($this->perPage), 
      ]); 
    }
}
