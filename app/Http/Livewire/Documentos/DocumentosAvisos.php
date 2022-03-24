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
use App\Models\VistoBueno;



class DocumentosAvisos extends Component
{
    use WithPagination;  
    public $Detalles=0;
    public $Historial=1;
    public $ID_Documento_T;
    
    public function DocumentosSubidosTotal($ID_Aviso_T){

        $VistoBueno =VistoBueno::find($ID_Aviso_T);
        $VistoBueno->FechaVisto = date("Y/m/d");
        $VistoBueno->save();  

        $ID_Documento_T  =  DB::table('VistoBueno') 
        ->select('ID_Documento')
        ->where('ID_Aviso_T', '=',$ID_Aviso_T)->first();

      
            $this->ID_Documento_T = $ID_Documento_T->ID_Documento;


        $this->Detalles='DocumentosSubidosTotal';
 
    }
    
 
    public function DocumentosSubidosTotal2($ID_Documento_T){

        $this->ID_Documento_T = $ID_Documento_T;

        $this->Detalles=1;
        $this->Historial=1;
        $this->Detalles='DocumentosSubidosTotal2';
 
    }
 
    public $ID_Aviso_T;
    public function Responder($ID_Aviso_T){

        $this->ID_Aviso_T=$ID_Aviso_T;
        $this->Detalles='ResponderSolicitud';
 
    }

    public $Comentario;
    public function IngresarComentario(){

        $VistoBueno =VistoBueno::find($this->ID_Aviso_T);
        $VistoBueno->visto  = 1;
        $VistoBueno->ObservacionR  = $this->Comentario;
        $VistoBueno->save();  

        $this->Detalles='0';
        $this->resetPage();
        $this->resetErrorBag();

    }


    public function Historial(){
        $this->Detalles=1;
        $this->Historial=0;
    }

    public function VolverPrincipal(){
        $this->Detalles=0;
        $this->resetPage();
        $this->resetErrorBag();
    }

    public function VolverPrincipal2(){
        $this->Detalles=0;
        $this->Historial=1;
        $this->resetPage();
        $this->resetErrorBag();
    }

    public function VolverListaDocumentos(){
        $this->Detalles=0;
    }

    public function VolverListaDocumentos2(){
        $this->Historial=0;
    }
 
    public $search; 
    public $perPage = '5';
    protected $paginationTheme = 'bootstrap'; 
    public function render()
    { 

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
  
        return view('livewire.documentos.documentos-avisos',[

            'postsSV' =>  DB::table('Documento') 
                ->leftjoin('Funcionarios', 'Documento.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T') 
                ->leftjoin('VistoBueno', 'Documento.ID_Documento_T', '=', 'VistoBueno.ID_Documento') 
                ->leftjoin('TipoDocumento', 'Documento.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
                ->where('ID_FuncionarioR', '=',$ID_Funcionario) 
                ->where('Visto', '=',0) 
                ->where(function($query) {
                $query->orwhere('Titulo_T', 'like', "%{$this->search}%")
                    ->orwhere('Nombre_T', 'like', "%{$this->search}%")
                    ->orwhere('Observacion_T', 'like', "%{$this->search}%");
            }) 
            ->paginate(3), 

            'posts' =>  DB::table('Documento') 
                ->leftjoin('Funcionarios', 'Documento.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T') 
                ->leftjoin('VistoBueno', 'Documento.ID_Documento_T', '=', 'VistoBueno.ID_Documento') 
                ->leftjoin('TipoDocumento', 'Documento.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
                ->where('ID_FuncionarioR', '=',$ID_Funcionario) 
                ->where('Visto', '=',1) 
                ->where(function($query) {
                $query->orwhere('Titulo_T', 'like', "%{$this->search}%")
                    ->orwhere('Nombre_T', 'like', "%{$this->search}%")
                    ->orwhere('Observacion_T', 'like', "%{$this->search}%");
            }) 
            ->paginate($this->perPage),
            'DocumentosSubidosTotal' =>  DB::table('DestinoDocumento') 
                ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
                ->select('Nombres','Apellidos','NombreDocumento','ID_DestinoDocumento')
                ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->paginate(4), 
      ]);
    }
}
 