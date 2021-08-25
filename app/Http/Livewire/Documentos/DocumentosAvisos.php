<?php

namespace App\Http\Livewire\Documentos;

use Livewire\Component;

use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\DocFunc;
use App\Models\Documento;
use App\Models\CreDocFunc; 
use App\Models\DocumentoFirma;
use App\Models\AvisoDocumento;



class DocumentosAvisos extends Component
{
    use WithPagination;  
    public $Detalles=0;

    //Boton datatable firmar documento  
    public $ID_Documento_T;

    //Boton datatable Enviar Documento  
    public function Opciones($ID_Documento_T)
    {
        $this->Detalles='1';
        $this->ID_Documento_T=$ID_Documento_T;

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
    
        $Datos =  DB::table('Documento') 
            ->leftjoin('AvisoDocumento', 'Documento.ID_Documento_T', '=', 'AvisoDocumento.ID_Documento')
            ->select('ID_Aviso_T') 
            ->where('ID_Documento_T', '=',$ID_Documento_T)
            ->where('ID_Funcionario', '=',$ID_Funcionario)->get();

            foreach ($Datos as $user){
              $ID_Aviso_T   = $user->ID_Aviso_T ;
            } 
   
            $AvisoDocumento =AvisoDocumento::find($ID_Aviso_T );
            $AvisoDocumento->Visto         = 1;
            $AvisoDocumento->Fecha         = date("Y/m/d");
            $AvisoDocumento->save();
    }


    public function VolverPrincipal(){
      $this->Detalles='0';
      $this->resetPage();
      $this->resetErrorBag();
    }
     
    public function Visto($ID_Documento_T)
    {

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
    
        $Datos =  DB::table('Documento') 
            ->leftjoin('AvisoDocumento', 'Documento.ID_Documento_T', '=', 'AvisoDocumento.ID_Documento')
            ->select('ID_Aviso_T') 
            ->where('ID_Documento_T', '=',$ID_Documento_T)
            ->where('ID_Funcionario', '=',$ID_Funcionario)->get();

        foreach ($Datos as $user){
              $ID_Aviso_T   = $user->ID_Aviso_T ;
        } 

        $AvisoDocumento =AvisoDocumento::find($ID_Aviso_T );
        $AvisoDocumento->Visto         = 1;
        $AvisoDocumento->Fecha         = date("Y/m/d");
        $AvisoDocumento->save();

    }



 
        public $search; 
        public $perPage = '5';
        protected $paginationTheme = 'bootstrap'; 
    
    public function render()
    {

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
  
        return view('livewire.documentos.documentos-avisos',[

            'posts' =>  DB::table('Documento') 
            ->leftjoin('Funcionarios', 'Documento.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T') 
        ->leftjoin('AvisoDocumento', 'Documento.ID_Documento_T', '=', 'AvisoDocumento.ID_Documento') 
        ->leftjoin('TipoDocumento', 'Documento.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
        ->where('ID_Funcionario', '=',$ID_Funcionario) 
        ->where(function($query) {
              $query->orwhere('Titulo_T', 'like', "%{$this->search}%")
                    ->orwhere('Nombre_T', 'like', "%{$this->search}%")
                    ->orwhere('Observacion_T', 'like', "%{$this->search}%");
        }) 
        ->paginate($this->perPage), 
        
      'FuncionariosAsig' =>  DB::table('DocFunc') 
        ->leftjoin('Funcionarios', 'DocFunc.ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
        ->where('ID_Documento', '=',$this->ID_Documento_T) 
        ->paginate(4)
      ]);
    }
}
 