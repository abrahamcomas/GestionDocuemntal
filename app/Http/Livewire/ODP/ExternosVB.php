<?php

namespace App\Http\Livewire\ODP;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\VistoBueno;
use App\Models\Documento;
use App\Models\InterPortaFuncionarioVB;
use App\Models\Portafolio;

class ExternosVB extends Component 
{
    public $Ayuda=0; 
    
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
    }
    public $R_ID_IntDocFunc;
    public $NombreEliminar;
    public function ComfirmarRechazo($ID_IntDocFunc){  


        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
        $OficinaPartes =  DB::table('Funcionarios')
        ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP') 
        ->select('Id_OP')  
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first();

        $InterPortaFuncionario =  DB::table('InterPortaFuncionario')
        ->where('IPF_Id_OP', '=',  $OficinaPartes->Id_OP)->get();

        $Existe = count($InterPortaFuncionario);


        if($Existe==0){
            
            $Datos =  DB::table('DocFunc')
            ->leftjoin('OficinaPartes', 'DocFunc.ID_OP_E', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
            ->select('Nombre_DepDir')  
            ->where('ID_IntDocFunc', '=', $ID_IntDocFunc)->first();

            $this->NombreEliminar = $Datos->Nombre_DepDir;

            $this->R_ID_IntDocFunc = $ID_IntDocFunc;
            
            $this->Detalles=1;
        }
        else{
            $this->Detalles=3;
        }
       
         
    }

    public $ObservacionRechazo;
    public $ContraseniaRechazo;
    protected $EliminarFirmante = ['ContraseniaRechazo' => 'required'];
    protected $MensajeEliminarFirmante = ['ContraseniaRechazo.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    public function RechazarPortafolio(){ 

        $this->validate($this->EliminarFirmante,$this->MensajeEliminarFirmante); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaRechazo], true)){ 

            $DocFunc =DocFunc::find($this->R_ID_IntDocFunc);
            $DocFunc->FechaE         = date("Y/m/d");
            $DocFunc->Estado         = 3;
            $DocFunc->Mensaje_R      = $this->ObservacionRechazo;
            $DocFunc->save();
            
            $this->Detalles='0';
            $this->resetPage();
            $this->resetErrorBag();
        }
        else{
            $this->ContraseniaFirmante="";
            session()->flash('message2', 'Contraseña incorrecta.');  
        }

        $this->ObservacionRechazo="";
        $this->ContraseniaRechazo="";
    }

    public $ID_Documento_T; 
    public $DestinoFuncionario;
    public $ObservacionPortafolio;

    protected $rulesEnviarPortafolio = ['DestinoFuncionario' => 'required'];

    protected $messEnviarPortafolio = ['DestinoFuncionario.required' =>'El campo "ENVIAR A: es obligatorio.'];

    public function EnviarPortafolio(){

        $this->validate($this->rulesEnviarPortafolio,$this->messEnviarPortafolio); 

              
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $OficinaPartes =  DB::table('Funcionarios')
        ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP') 
        ->select('Id_OP')  
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first();
 
    
        $InterPortaFuncionarioVB                      = new InterPortaFuncionarioVB;
        $InterPortaFuncionarioVB->IPF_ID_Funcionario  = $this->DestinoFuncionario;
        $InterPortaFuncionarioVB->IPF_Portafolio      = $this->ID_Documento_T;  
        $InterPortaFuncionarioVB->IPF_Id_OP           = $OficinaPartes->Id_OP;  
        $InterPortaFuncionarioVB->FechaR              = date("Y/m/d");  
        $InterPortaFuncionarioVB->Visto               = 0;  
        $InterPortaFuncionarioVB->Estado              = 0;  
        $InterPortaFuncionarioVB->Observacion         = $this->ObservacionPortafolio;  
        $InterPortaFuncionarioVB->save(); 
         
        $this->DestinoFuncionario="";
        $this->ObservacionPortafolio="";

        session()->flash('message', 'Enviado correctamente.');  
    }


    public function AnularFirmantes($IPFVB){
                           
        $InterPortaFuncionario =InterPortaFuncionarioVB::find($IPFVB);
        $InterPortaFuncionario->delete();
                              
        session()->flash('message2', 'V°B° eliminado');
                            
    }

    public $ID_Aviso_T;

    public function Responder($ID_Aviso_T,$ID_Documento_T){
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
                
        $VistoBueno =VistoBueno::find($ID_Aviso_T);
        $VistoBueno->Visto        = 1;
        $VistoBueno->FechaVisto   = date("Y/m/d");
        $VistoBueno->save();

        $this->ID_Documento_T=$ID_Documento_T;
        $this->ID_Aviso_T=$ID_Aviso_T;
        $this->Detalles=2;
    }
 


    public function ConfirmarFinalizarPortafolio(){
        $this->Detalles=4;
    }

 

    public $ObservacionFinalizado;
    public $RespuestaFinal;
 
    protected $rulesEnviarPortafolioR = ['RespuestaFinal' => 'required'];

    protected $messEnviarPortafolioR = ['RespuestaFinal.required' =>'El campo "RESPUESTA*" es obligatorio.'];


    public function FinalizarPortafolio(){


        $this->validate($this->rulesEnviarPortafolioR,$this->messEnviarPortafolioR); 

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
        $OficinaPartes =  DB::table('Funcionarios')
        ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP') 
        ->select('Id_OP')  
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first();

        $ComprobarFinalizar =  DB::table('Portafolio')
        ->leftjoin('InterPortaFuncionarioVB', 'Portafolio.ID_Documento_T', '=', 'InterPortaFuncionarioVB.IPF_Portafolio') 
        ->select('IPF_Id_OP')
        ->where(function($query) {
            $query->orwhere('Estado', '=',  1)
                    ->orwhere('Estado', '=',  2);
        })  
        ->where('IPF_Id_OP', '=',  $OficinaPartes->Id_OP)->get();
 
        $Numero = count($ComprobarFinalizar); 

        

        if($Numero>=1){

            $Comprobar =  DB::table('Portafolio')
            ->leftjoin('InterPortaFuncionarioVB', 'Portafolio.ID_Documento_T', '=', 'InterPortaFuncionarioVB.IPF_Portafolio') 
            ->select('IPF_Id_OP')
            ->where('Estado', '=',  0)
            ->where('IPF_Id_OP', '=',  $OficinaPartes->Id_OP)->get();
    
            $Num = count($Comprobar); 
            
            if($Num==0){
 
                $ID_IntDocFunc =  DB::table('Portafolio')
                ->leftjoin('DocFunc', 'Portafolio.ID_Documento_T', '=', 'DocFunc.ID_Documento') 
                ->select('ID_IntDocFunc')  
                ->where('ID_Documento_T', '=',  $this->ID_Documento_T)->first();
        
                $ID_IntDocFunc = $ID_IntDocFunc->ID_IntDocFunc;
                        
                $VistoBueno =VistoBueno::find($this->ID_Aviso_T);
                $VistoBueno->Estado       = $this->RespuestaFinal;
                $VistoBueno->Fecha        = date("Y/m/d");
                $VistoBueno->ObservacionR = $this->ObservacionFinalizado;
                $VistoBueno->save();


                if($this->RespuestaFinal==2){

                    $Portafolio                      = Portafolio::find($this->ID_Documento_T);
                    $Portafolio->Estado_T            = 3;
                    $Portafolio->save();
 

                }

                session()->flash('message', 'Portafolio confirmado correctamente.');  
                $this->Detalles=0;
            }
            else{
                session()->flash('message4', 'Para confirmar un portafolio debe existir al menos un destinatario, y se encuentre aprobado o rechazado.');  
            }

        }else{
            session()->flash('message4', 'Para confirmar un portafolio debe existir al menos un destinatario, y se encuentre aprobado o rechazado.');  
        }
  
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
    public function render()
    {


        if($this->Orden==1){
            $Orden='ASC';
        }else{
            $Orden='DESC';
        }


        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
        $OficinaPartes =  DB::table('Funcionarios')
        ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP') 
        ->select('Id_OP','ID_OP_LDT')  
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first();

        return view('livewire.o-d-p.externos-v-b',[  
			'posts' =>  DB::table('Portafolio') 
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
            ->leftjoin('OficinaPartes', 'Portafolio.ID_OficinaP', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->leftjoin('VistoBueno', 'Portafolio.ID_Documento_T', '=', 'VistoBueno.ID_Documento') 
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->where(function($query) {
                $query->orwhere('Folio', 'like', "%{$this->search}%")
                        ->orwhere('Titulo_T', 'like', "%{$this->search}%")
                        ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                        ->orwhere('Observacion_T', 'like', "%{$this->search}%");
            })  
            ->where('Estado', '=', 0) 
            ->where('ID_OP_R', '=', $OficinaPartes->Id_OP)
            ->orderBy('Fecha_T', $Orden)
            ->paginate($this->perPage), 
 
            'FuncionariosAsig' =>  DB::table('LugarDeTrabajo') 
            ->leftjoin('Funcionarios', 'LugarDeTrabajo.ID_Funcionario_LDT', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('ID_Funcionario_T','Nombres','Apellidos') 
            ->where('ID_DepDirecciones_LDT', '=',$OficinaPartes->ID_OP_LDT)   
            ->where('Estado_LDT', '=', 1) 
            ->get(), 

            'MostrarDocumentos' =>  DB::table('Portafolio')  
            ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
            ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('Privado','ID_FSube','NombreDocumento','ID_DestinoDocumento','Nombres','Apellidos')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->get(),
            
            'DestinoPortafolio' =>  DB::table('InterPortaFuncionarioVB') 
            ->leftjoin('Funcionarios', 'InterPortaFuncionarioVB.IPF_ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('FechaR','Visto','Estado','Observacion','Observacion','IPFVB','Nombres','Apellidos') 
            ->where('IPF_Portafolio', '=',$this->ID_Documento_T)
            ->where('IPF_Id_OP', '=',$OficinaPartes->Id_OP)   
            ->get(),

            'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
            ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select("Nombres","Apellidos")
            ->first(),
        ]); 
    }
}
  