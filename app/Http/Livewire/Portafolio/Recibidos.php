<?php

namespace App\Http\Livewire\Portafolio;

use Livewire\Component;
use Livewire\WithPagination;  
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\DocFunc;
use App\Models\CreDocFunc;
use App\Models\DocumentoFirma;
use App\Models\InterPortaFuncionario;
use App\Models\Portafolio;

class Recibidos extends Component
{
    public $Ayuda=0; 
     
    public function Ayuda(){
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
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

    use WithPagination;  
    use WithFileUploads; 
    public $search; 
    public $perPage = 5;
    //Pagina principal  
    public $Detalles=0;
    public $ID_Documento_T; 
    public $IPF_ID;

    public function EnviarDocumento($ID_Documento_T,$IPF_ID){


        $InterPortaFuncionario                  =InterPortaFuncionario::find($IPF_ID);
        $InterPortaFuncionario->Visto          = 1;
        $InterPortaFuncionario->save(); 

        $this->ID_Documento_T=$ID_Documento_T;

        $this->IPF_ID=$IPF_ID;

        $this->Detalles=4;
    
    }

    public function VolverPrincipal(){
        $this->Detalles=0;
        $this->resetPage(); 
        $this->resetErrorBag(); 
    }

    public function clear()
    {
      $this->search=''; 
      $this->perPage='5'; 
    }  

    
    
    
    public $ObservacionPortafolio; 
    public function RespuestaPortafolio(){
         
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $TotalArchivos =  DB::table('Portafolio')
        ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento') 
        ->select('ID_DestinoDocumento') 
        ->where('ID_Documento_T', '=',  $this->ID_Documento_T)->get();
        
        $ID_Lugar =  DB::table('LugarDeTrabajo')
        ->leftjoin('OficinaPartes', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'OficinaPartes.ID_OP_LDT') 
        ->select('Id_OP')
        ->where('ID_Funcionario_LDT', '=',$ID_Funcionario)
        ->where('Estado_LDT', '=',1)->first();

        $Id_OP  = $ID_Lugar->Id_OP;

        $DocFunc                  =DocFunc::where('ID_Documento', $this->ID_Documento_T)->where('ID_OP_R', $Id_OP)->first();
        $DocFunc->Estado          = 2;
        $DocFunc->save();

        $NumeroArchivos = count($TotalArchivos);


            $InterPortaFuncionario                  =InterPortaFuncionario::find($this->IPF_ID);
            $InterPortaFuncionario->Estado          = 2;
            $InterPortaFuncionario->ObservacionE    = $this->ObservacionPortafolio;
            $InterPortaFuncionario->save(); 

            $Portafolio                      = Portafolio::find($this->ID_Documento_T);
            $Portafolio->Estado_T            = 55;
            $Portafolio->save(); 
                
            $this->Detalles=0;

        session()->flash('message1', 'Solicitud rechazada.');  

    } 



  





    public $Funcionarios; 
    protected $paginationTheme = 'bootstrap'; 

    public $Existe;

      //Crear imagen firma 
      public $Nombres;
      public $Apellidos;
      public $Rut;
      public $Oficina;
      public $Cargo;
      public $Creado=1;

      public function Creada(){ 
  
          $this->Creado = 0;  
  
      }

      public $cuantos;
    public function render()
    {

        $this->Funcionarios =  DB::table('Funcionarios')->get();

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;


        $Cuantos =  DB::table('DestinoDocumento')
        ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento') 
        ->select('ID_DestinoDocumento')
        ->where('ID_Funcionario', '=', $ID_Funcionario)
        ->where('Firmado', '=',0)
        ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->get();

        $this->cuantos=count($Cuantos);


        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->select('Rut','Nombres','Apellidos','Nombre_DepDir','Cargo','ID_DepDir')->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

  
        $this->Rut = $DatosFirma->Rut;
        $this->Nombres = $DatosFirma->Nombres;
        $this->Apellidos = $DatosFirma->Apellidos; 
        $this->Oficina = $DatosFirma->Nombre_DepDir;
        $this->Cargo = $DatosFirma->Cargo;

        $ID_DepDir = $DatosFirma->ID_DepDir;

        $Lista =  DB::table('ImagenFirma') 
        ->where('id_Funcionario_T', '=',$ID_Funcionario)
        ->get(); 

        $this->Existe=count($Lista);

        
        return view('livewire.portafolio.recibidos',[
        'posts' =>  DB::table('InterPortaFuncionario')
            ->leftjoin('Portafolio', 'InterPortaFuncionario.IPF_Portafolio', '=', 'Portafolio.ID_Documento_T')
            ->leftjoin('OficinaPartes', 'Portafolio.ID_OficinaP', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T') 
            ->where(function($query) { 
                $query->orwhere('Folio', 'like', "%{$this->search}%")
                    ->orwhere('Titulo_T', 'like', "%{$this->search}%"); 
            })  
            ->where('Estado', '=', 0)             
            ->where('IPF_ID_Funcionario', '=', $ID_Funcionario)->orderBy('IPF_ID', 'asc')   
            ->paginate($this->perPage), 
        
         
        
        
        'MostrarDocumentos' =>  DB::table('DestinoDocumento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
            ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('ID_FSube','NombreDocumento','ID_DestinoDocumento','ID_DocumentoFirma','ID_Funcionario','ID_Documento','FechaFirma','Firmado','Nombres','Apellidos')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
            ->where('ID_Funcionario', '=',$ID_Funcionario)->paginate(4),
        
        
        
        
        'FuncionariosAsig' =>  DB::table('DocFunc') 
            ->leftjoin('OficinaPartes AS RECEP', 'DocFunc.ID_OP_R', '=', 'RECEP.Id_OP') 
            ->leftjoin('DepDirecciones', 'RECEP.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
            ->select('ID_IntDocFunc','Mensaje_E','Mensaje_R','FechaR','FechaE','Estado','Visto','Fecha_V','Nombre_DepDir') 
            ->where('ID_Documento', '=',$this->ID_Documento_T)   
            ->paginate(4),


        'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
            ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select("Nombres","Apellidos")->where('ID_OP_LDT', '=',$ID_DepDir)
            ->first(),

        'DestinoFirmantes' =>  DB::table('InterPortaFuncionario') 
                ->leftjoin('Funcionarios', 'InterPortaFuncionario.IPF_ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T') 
                ->where('IPF_Portafolio', '=',$this->ID_Documento_T)   
                ->get(),  

        'VistoBueno' =>  DB::table('InterPortaFuncionarioVB') 
            ->leftjoin('Funcionarios', 'InterPortaFuncionarioVB.IPF_ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
            ->where('IPF_Portafolio', '=',$this->ID_Documento_T) 
            ->get(), 
        ]);
    }
}
 