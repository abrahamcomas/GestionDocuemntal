<?php

namespace App\Http\Livewire\ODP;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\RecibidosModels;
use App\Models\Documento;
use App\Models\InterPortaFuncionarioEnviado;
use App\Models\Portafolio;

class Recibidos extends Component
{
    public $Ayuda=0;  
    public $AnioSelect;
    
    public function Ayuda(){ 
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }
    
    use WithPagination;  

    public $search; 
    public $perPage = 5;

    public function clear()
    {
      $this->search='';
      $this->perPage='5'; 
      $this->AnioSelect=date('Y');
    }

    public $ID_Ricibidos;

    public function Responder($ID_Ricibidos,$ID_Documento_T){
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
                
        $RecibidosModels =RecibidosModels::find($ID_Ricibidos);
        $RecibidosModels->R_Visto         = 1;
        $RecibidosModels->R_FechaVisto    = date("Y/m/d");
        $RecibidosModels->save();

        $this->ID_Documento_T=$ID_Documento_T;
        $this->ID_Ricibidos=$ID_Ricibidos;
        $this->Detalles=2;
    }

    public $ID_Documento_T; 
    public $DestinoFuncionario;
    public $ObservacionPortafolio;

    protected $rulesEnviarPortafolio = ['DestinoFuncionario' => 'required'];

    protected $messEnviarPortafolio = ['DestinoFuncionario.required' =>'El campo "COMPARTIR CON: es obligatorio.'];

    public function EnviarPortafolio(){

        $this->validate($this->rulesEnviarPortafolio,$this->messEnviarPortafolio); 
      
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
  
        $OficinaPartes =  DB::table('OficinaPartes')
        ->select('Id_OP','ID_OP_LDT','ID_Jefatura')
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)
        ->where('ActivoODP', '=', 2)
        ->where('Original', '=', 1)->first(); 

        if(empty($OficinaPartes)){

            $OficinaPartes =  DB::table('OficinaPartes')
            ->select('Id_OP','ID_OP_LDT','ID_Jefatura')
            ->where('id_Funcionario_OP', '=', $ID_Funcionario)
            ->where('ActivoODP', '=', 2)->first(); 

        }

        $InterPortaFuncionarioEnviado                      = new InterPortaFuncionarioEnviado;
        $InterPortaFuncionarioEnviado->IPF_ID_Funcionario  = $this->DestinoFuncionario;
        $InterPortaFuncionarioEnviado->IPF_Portafolio      = $this->ID_Documento_T;  
        $InterPortaFuncionarioEnviado->IPF_Id_OP           = $OficinaPartes->Id_OP;  
        $InterPortaFuncionarioEnviado->ID_OP_LDT_P_E       = $OficinaPartes->ID_OP_LDT;  
        $InterPortaFuncionarioEnviado->FechaR              = date("Y/m/d");  
        $InterPortaFuncionarioEnviado->Visto               = 0;  
        $InterPortaFuncionarioEnviado->Estado              = 0;  
        $InterPortaFuncionarioEnviado->Observacion         = $this->ObservacionPortafolio;  
        $InterPortaFuncionarioEnviado->save(); 

        $Recibidos                      = RecibidosModels::find($this->ID_Ricibidos);
        $Recibidos->R_Estado            = 1;  
        $Recibidos->save(); 
         
        $this->DestinoFuncionario="";
        $this->ObservacionPortafolio="";

        session()->flash('message', 'Compartido correctamente.');  
    }


    public function AnularFirmantes($IPFVB){
                           
        $InterPortaFuncionarioEnviado =InterPortaFuncionarioEnviado::find($IPFVB);
        $InterPortaFuncionarioEnviado->delete();
                              
        session()->flash('message2', 'Eliminado');
                            
    }

   

    //Pagina principal 
    public $Detalles=0;
    public function VolverPrincipal(){
        $this->Opciones=0;
           $this->Detalles=0;
           $this->resetPage();
           $this->resetErrorBag(); 
    }

    protected $paginationTheme = 'bootstrap'; 
    
    public $Orden;
    public $Compartidos;
    public $OPDSelectNombre; 
    public function render()
    { 
        if ($this->AnioSelect=='') {  
            $this->AnioSelect=date('y'); 
        }

        if ($this->Compartidos=='') { 
            $this->Compartidos=0; 
        }

        if($this->Orden==1){
            $Orden='ASC';
        }else{
            $Orden='DESC';
        }
  
 
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $OPDSelect =  DB::table('OficinaPartes')
        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->select('Nombre_DepDir')
        ->where('id_Funcionario_OP', '=',$ID_Funcionario)
        ->where('ActivoODP', '=',2)
        ->first();

        $this->OPDSelectNombre = $OPDSelect->Nombre_DepDir; 

        $Id_OficinaParte =  DB::table('OficinaPartes')
        ->select('Id_OP','ID_OP_LDT','ID_Jefatura')
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)
        ->where('ActivoODP', '=', 2)
        ->where('Original', '=', 1)->first(); 

        if(empty($Id_OficinaParte)){

            $Id_OficinaParte =  DB::table('OficinaPartes')
            ->select('Id_OP','ID_OP_LDT','ID_Jefatura')
            ->where('id_Funcionario_OP', '=', $ID_Funcionario)
            ->where('ActivoODP', '=', 2)->first(); 

        }

        return view('livewire.o-d-p.recibidos',[  
			'posts' =>  DB::table('Portafolio') 
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
            ->leftjoin('OficinaPartes', 'Portafolio.ID_OficinaP', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->leftjoin('Recibidos', 'Portafolio.ID_Documento_T', '=', 'Recibidos.R_ID_Documento') 
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->where(function($query) {
                $query->orwhere('Folio', 'like', "%{$this->search}%")
                        ->orwhere('Titulo_T', 'like', "%{$this->search}%")  
                        ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                        ->orwhere('Observacion_T', 'like', "%{$this->search}%");
            })  
            ->where('Portafolio.Anio','=', $this->AnioSelect)
            ->where('R_Estado', '=', $this->Compartidos) 
            ->where('ID_OP_LDT_P_RR', '=', $Id_OficinaParte->ID_OP_LDT)
            ->orderBy('Fecha_T', $Orden)  
            ->paginate($this->perPage), 

            'Anio' =>  DB::table('Portafolio')
            ->select('Anio')
            ->distinct('Anio')           
            ->get(), 
 
            'FuncionariosAsig' =>  DB::table('LugarDeTrabajo') 
            ->leftjoin('Funcionarios', 'LugarDeTrabajo.ID_Funcionario_LDT', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('ID_Funcionario_T','Nombres','Apellidos') 
            ->where('ID_DepDirecciones_LDT', '=',$Id_OficinaParte->ID_OP_LDT)   
            ->where('Estado_LDT', '=', 1) 
            ->get(), 

            'MostrarDocumentos' =>  DB::table('Portafolio')  
            ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
            ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('Privado','ID_FSube','NombreDocumento','ID_DestinoDocumento','Nombres','Apellidos')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->get(),
            
            'DestinoPortafolio' =>  DB::table('InterPortaFuncionarioEnviado') 
            ->leftjoin('Funcionarios', 'InterPortaFuncionarioEnviado.IPF_ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('FechaR','Visto','Estado','Observacion','Observacion','IPFE_ID','Nombres','Apellidos') 
            ->where('IPF_Portafolio', '=',$this->ID_Documento_T)
            ->where('IPF_Id_OP', '=',$Id_OficinaParte->Id_OP)   
            ->get(),
        ]);
    }
}
 