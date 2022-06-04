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
    public $NombreImagen;
    public $photo;  

    public $ID_Funcionario_T;  

    public function clear()
    {
      $this->search=''; 
      $this->perPage='5';
    }
 
    public $NombreSeleccionado;  
    public $ApellidoSeleccionado;  
    public function Agregar($ID_Documento_T){ 

        
        $Datos =  DB::table('Funcionarios')
       ->select('Nombres','Apellidos')
        ->where('ID_Funcionario_T', '=',$ID_Documento_T)->first();

        $this->NombreSeleccionado=$Datos->Nombres;
        $this->ApellidoSeleccionado=$Datos->Apellidos;


        $this->ID_Funcionario_T=$ID_Documento_T;
        $this->Detalles=1;
    }

    public function Eliminar($ID_Imagen){ 

      

        $ImagenFirma =  DB::table('ImagenFirma')->select('Ruta')->where('ID_Imagen', '=',$ID_Imagen)->first();

        $nommbreArchivo = Storage::disk('Firmas')->delete($ImagenFirma->Ruta); 

        $FuncionarioModels =ImagenFirma::find($ID_Imagen);
        $FuncionarioModels->delete();

        $this->Detalles=3;  
    }


    

    protected $rules2 = [
        'NombreImagen' => 'required', 
        'photo' => 'required', 
    ];
 
    protected $messages2 = [
        'NombreImagen.required' =>'El campo Nombre Imagen es obligatorio.',
        'photo.required' =>'El campo Imagen Firma es obligatorio.',
    ];

    public function IngresoImagen()
    {
        $this->validate($this->rules2,$this->messages2);  

        $ID_Maximo =  DB::table('ImagenFirma')->select('ID_Imagen')->orderBy('ID_Imagen', 'desc')->first();

        if(empty($ID_Maximo->ID_Imagen)){
            $ID_Maximo=1;
        }else{
            $ID_Maximo= $ID_Maximo->ID_Imagen;
        }


        $Ruta= $ID_Maximo.''.$this->ID_Funcionario_T;

        $nombreArchivo = Storage::disk('Firmas')->put($this->ID_Funcionario_T, $this->photo);
        
        $ImagenFirma                    = new ImagenFirma;
        $ImagenFirma->id_Funcionario_T  = $this->ID_Funcionario_T;
        $ImagenFirma->NombreImagen      = $this->NombreImagen;
        $ImagenFirma->Ruta              = $nombreArchivo;
        $ImagenFirma->save();

        $this->NombreImagen="";
        $this->photo="";
        $this->Detalles=2;     
                      
    }   

    public function Volver()
    {
 
        $this->Detalles=0;                    
   
    } 

    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
        return view('livewire.root.subir-imagen-firma',[
            'Firmas' =>  DB::table('ImagenFirma')
                ->where('id_Funcionario_T', '=', $this->ID_Funcionario_T)
                ->get(), 
            'Lista' =>  DB::table('Funcionarios')
                ->where(function($query) { 
                    $query->orwhere('Rut', 'like', "%{$this->search}%")
                    ->orwhere('Nombres', 'like', "%{$this->search}%")
                    ->orwhere('Apellidos', 'like', "%{$this->search}%");
              }) 
            ->paginate($this->perPage), 
      ]); 
    } 
}
