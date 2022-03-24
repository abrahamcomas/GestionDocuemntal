<?php

namespace App\Http\Livewire\Portafolio;

use Livewire\Component;
use Livewire\WithPagination; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 

class DocumentoEnProceso extends Component
{
    public $Ayuda=0; 
    
    public function Ayuda(){
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }
    
    public $ID_Documento_T;
    public $Detalles=0;

    public function Detalles($ID_Documento_T)
    {
      $this->Detalles=1;
      $this->ID_Documento_T=$ID_Documento_T;
    }

    use WithPagination;  
    public $search; 
    public $perPage = 5;
   
    public function clear()
    {
        $this->search='';
        $this->perPage=5;
     
    }
 
    public function Volver(){

        $this->Detalles=0;
    }
    
    public $Cambiar=0;
 
    public function CambiarVB()
    {
      $this->Cambiar=1; 
    }

    public function CambiarFirmantes()
    {
      $this->Cambiar=0; 
    }
 
   
public $Funcionarios;
public $TipoFirma;

protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
 
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->select('ID_DepDir')->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

        $ID_DepDir = $DatosFirma->ID_DepDir;


        return view('livewire.portafolio.documento-en-proceso',[
            'posts' =>  DB::table('Portafolio') 
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->where(function($query) {
                $query->orwhere('Estado_T', '=', 1)
                        ->orwhere('Estado_T', '=', 2);  
                })  
                ->where(function($query) {
                    $query->orwhere('Folio', 'like', "%{$this->search}%")
                            ->orwhere('Titulo_T', 'like', "%{$this->search}%")
                          ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                          ->orwhere('Observacion_T', 'like', "%{$this->search}%"); 
            })  
            ->where('ID_Funcionario_Sol', '=', $ID_Funcionario)     
            ->paginate($this->perPage),
            'Anio' =>  DB::table('Portafolio')
            ->select('Anio')
            ->distinct('Anio')           
            ->get(),  
            'DestinoFirmantes' =>  DB::table('DocFunc') 
            ->leftjoin('OficinaPartes', 'DocFunc.ID_OP_R', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->where('ID_Documento', '=',$this->ID_Documento_T)   
            ->get(), 
            'VistoBueno' =>  DB::table('VistoBueno') 
            ->leftjoin('OficinaPartes', 'VistoBueno.ID_OP_R', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->where('ID_Documento', '=',$this->ID_Documento_T) 
            ->get(),
            'MostrarDocumentos' =>  DB::table('DestinoDocumento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
            ->select('ID_FSube','ID_DestinoDocumento','NombreDocumento','ID_DocumentoFirma','ID_Documento','FechaFirma','Firmado')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
            ->where('ID_Funcionario', '=',$ID_Funcionario)->paginate(4),
            'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
            ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select("Nombres","Apellidos")->where('ID_OP_LDT', '=',$ID_DepDir)
            ->first(),
            ]);
    }
} 
 