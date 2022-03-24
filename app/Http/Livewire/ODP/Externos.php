<?php

namespace App\Http\Livewire\ODP;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\DocFunc;
use App\Models\Documento;
use App\Models\DocumentoFirma;
use App\Models\InterPortaFuncionario;
use App\Models\IntePortSubrog;
use App\Models\Portafolio;

class Externos extends Component
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

    public function clear(){
      
        $this->search='';
        $this->perPage='5'; 
    
    }

    public $R_ID_IntDocFunc;
    public $NombreEliminar;
    public $ID_PortafolioRechazo;
    public function ComfirmarRechazo($ID_IntDocFunc,$ID_Documento_T){  

        $this->ID_PortafolioRechazo = $ID_Documento_T;

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

 
        $Portafolio =Portafolio::find($this->ID_PortafolioRechazo);
        $Portafolio->Estado_T         = 55;
        $Portafolio->save();  

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

        $IngresadoInterPortaFuncionario =  DB::table('InterPortaFuncionario')
        ->where('IPF_ID_Funcionario', '=', $this->DestinoFuncionario) 
        ->where('IPF_Portafolio', '=', $this->ID_Documento_T) 
        ->where('Estado', '!=', 11) 
        ->where('Estado', '!=', 22)   
        ->get();

        $Numeros = count($IngresadoInterPortaFuncionario);

       if($Numeros==0){
  
            $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

            $OficinaPartes =  DB::table('Funcionarios')
            ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP') 
            ->select('Id_OP')  
            ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first();
        
            $InterPortaFuncionario                      = new InterPortaFuncionario;
            $InterPortaFuncionario->IPF_ID_Funcionario  = $this->DestinoFuncionario;
            $InterPortaFuncionario->IPF_Portafolio      = $this->ID_Documento_T;  
            $InterPortaFuncionario->IPF_Id_OP           = $OficinaPartes->Id_OP;  
            $InterPortaFuncionario->FechaR              = date("Y/m/d");  
            $InterPortaFuncionario->Visto               = 0;  
            $InterPortaFuncionario->Estado              = 0;  
            $InterPortaFuncionario->Observacion         = $this->ObservacionPortafolio;  
            $InterPortaFuncionario->save(); 
            
            $ID_OficinaPartes =  DB::table('DestinoDocumento') 
                                    ->select('ID_DestinoDocumento')
                                    ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
                                    ->get();

                                    foreach ($ID_OficinaPartes as $Firmas){  

                                        $VariableFirma =  DB::table('DocumentoFirma') 
                                        ->select('ID_Funcionario','ID_Documento')
                                        ->where('ID_Funcionario', '=',$this->DestinoFuncionario)
                                        ->where('ID_Documento', '=',$Firmas->ID_DestinoDocumento)
                                        ->get();
                                        
                                        $ExisteFirma= count($VariableFirma);   
                                        
                                        if($ExisteFirma==0){
                                
                                            $DocumentoFirma                  = new DocumentoFirma;
                                            $DocumentoFirma->ID_Funcionario  = $this->DestinoFuncionario;
                                            $DocumentoFirma->ID_Documento    = $Firmas->ID_DestinoDocumento;  
                                            $DocumentoFirma->Firmado         = 0;  
                                            $DocumentoFirma->save(); 
                                        
                                        
                                        
                                        }
                                    
                                    }
            
            $this->DestinoFuncionario="";
            $this->ObservacionPortafolio="";

            session()->flash('message', 'Enviado correctamente.');  
        }
        else{
            
            session()->flash('message2', 'ERROR, Solicitud ya enviada.');  
        
        }
    
    }  

    public $ID_IntDocFunc;

    public function Responder($ID_IntDocFunc,$ID_Documento_T){
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
                
        $DocFunc =DocFunc::find($ID_IntDocFunc);
        $DocFunc->Visto        = 1;
        $DocFunc->Fecha_V      = date("Y/m/d");
        $DocFunc->save();

        $this->ID_Documento_T=$ID_Documento_T;
        $this->ID_IntDocFunc=$ID_IntDocFunc;
        $this->Detalles=2;
    }
 
    public function AnularFirmantes($IPF_ID,$ID_Funcionario_T){

        $ID_OficinaPartes =  DB::table('DestinoDocumento') 
        ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
        ->select('ID_DocumentoFirma')
        ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
        ->where('ID_Funcionario', '=',$ID_Funcionario_T)
        ->get();

        foreach ($ID_OficinaPartes as $Borrar) {  

            $DocumentoFirma =DocumentoFirma::find($Borrar->ID_DocumentoFirma);
            $DocumentoFirma->delete();
        
        }

        
                           
        $InterPortaFuncionario =InterPortaFuncionario::find($IPF_ID);
        $InterPortaFuncionario->delete();

        $IntePortSubrog =  DB::table('IntePortSubrog') 
        ->select('Id_IntePortSubrog')
        ->where('ID_Documento_T_P', '=',$this->ID_Documento_T)
        ->first();

        if(!empty($IntePortSubrog->Id_IntePortSubrog)){
            $IntePortSubrog =IntePortSubrog::find($IntePortSubrog->Id_IntePortSubrog);
            $IntePortSubrog->delete();
        }
                              
        session()->flash('message2', 'Firmante eliminado');
                            
    }

    public function ConfirmarFinalizarPortafolio(){
        $this->Detalles=4;
    }

    public $ObservacionFinalizado;
    public $RespuestaFinal=1;

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
        ->leftjoin('InterPortaFuncionario', 'Portafolio.ID_Documento_T', '=', 'InterPortaFuncionario.IPF_Portafolio') 
        ->select('IPF_Id_OP')   
        ->where(function($query) {
            $query->orwhere('Estado', '=', 1)
                    ->orwhere('Estado', '=', 2);
        }) 
        ->where('IPF_Id_OP', '=',  $OficinaPartes->Id_OP)->get();
 
 
        $Numero = count($ComprobarFinalizar);
 

        if($Numero>=1){
            $ID_IntDocFunc =  DB::table('Portafolio')
            ->leftjoin('DocFunc', 'Portafolio.ID_Documento_T', '=', 'DocFunc.ID_Documento') 
            ->select('ID_IntDocFunc')  
            ->where('ID_Documento_T', '=',  $this->ID_Documento_T)->first();
    
            $ID_IntDocFunc = $ID_IntDocFunc->ID_IntDocFunc;
                    
            $DocFunc =DocFunc::find($ID_IntDocFunc);
            $DocFunc->FechaE       = date("Y/m/d");
            $DocFunc->Estado       = $this->RespuestaFinal;
            $DocFunc->Mensaje_R    = $this->ObservacionFinalizado;
            $DocFunc->save();

            session()->flash('message', 'Portafolio devuelto correctamente.');  
            $this->Detalles=0;

        }else{
            session()->flash('message4', 'Para finalizar un portafolio debe existir al menos un firmante, y que haya aceptado o rechazado tal portafolio.');  
        }
  
    }

    public $ObservacionPortafolioSubr;

    public function EnviarSubrogante($ID_Funcionario_TS,$Id_subrogante){

        $IngresadoIntePortSubrog =  DB::table('IntePortSubrog')
        ->leftjoin('Subrogante', 'IntePortSubrog.Id_subrogante_P', '=', 'Subrogante.Id_subrogante')
        ->where('ID_Documento_T_P', '=', $this->ID_Documento_T) 
        ->where('Id_Subrogante_S', '=', $ID_Funcionario_TS)
        ->get();

        $Numeros = count($IngresadoIntePortSubrog);

       if($Numeros==0){

                $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

                $OficinaPartes =  DB::table('Funcionarios')
                ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP') 
                ->select('Id_OP')  
                ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first();
 
                $InterPortaFuncionario                      = new InterPortaFuncionario;
                $InterPortaFuncionario->IPF_ID_Funcionario  = $ID_Funcionario_TS;
                $InterPortaFuncionario->IPF_Portafolio      = $this->ID_Documento_T;  
                $InterPortaFuncionario->IPF_Id_OP           = $OficinaPartes->Id_OP;  
                $InterPortaFuncionario->FechaR              = date("Y/m/d");  
                $InterPortaFuncionario->Visto               = 0;  
                $InterPortaFuncionario->Estado              = 0;  
                $InterPortaFuncionario->Observacion         = $this->ObservacionPortafolioSubr;  
                $InterPortaFuncionario->save(); 
                        
                $IntePortSubrog                         = new IntePortSubrog;
                $IntePortSubrog->ID_Documento_T_P       = $this->ID_Documento_T;
                $IntePortSubrog->Id_subrogante_P        = $Id_subrogante;  
                $IntePortSubrog->save(); 
       
        
                $ID_OficinaPartes =  DB::table('DestinoDocumento') 
                                ->select('ID_DestinoDocumento')
                                ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
                                ->get();

                                foreach ($ID_OficinaPartes as $Firmas){  

                                    $VariableFirma =  DB::table('DocumentoFirma') 
                                    ->select('ID_Funcionario','ID_Documento')
                                    ->where('ID_Funcionario', '=',$ID_Funcionario_TS)
                                    ->where('ID_Documento', '=',$Firmas->ID_DestinoDocumento)
                                    ->get();
                                    
                                    $ExisteFirma= count($VariableFirma);   
                                    
                                    if($ExisteFirma==0){
                            
                                        $DocumentoFirma                  = new DocumentoFirma;
                                        $DocumentoFirma->ID_Funcionario  = $ID_Funcionario_TS;
                                        $DocumentoFirma->ID_Documento    = $Firmas->ID_DestinoDocumento;  
                                        $DocumentoFirma->Firmado         = 0;  
                                        $DocumentoFirma->save(); 
                                       
                                    }
                                
                                }

                $this->ObservacionPortafolioSubr="";


                session()->flash('message', 'Enviado correctamente.'); 

        }
        else{
            session()->flash('message2', 'ERROR. Portafolio ya enviado..');  
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
        
        return view('livewire.o-d-p.externos',[  
			'posts' =>  DB::table('Portafolio') 
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
            ->leftjoin('OficinaPartes', 'Portafolio.ID_OficinaP', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->leftjoin('DocFunc', 'Portafolio.ID_Documento_T', '=', 'DocFunc.ID_Documento') 
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->where(function($query) {
                $query->orwhere('Folio', 'like', "%{$this->search}%")
                        ->orwhere('Titulo_T', 'like', "%{$this->search}%")
                        ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                        ->orwhere('Observacion_T', 'like', "%{$this->search}%");
            })  
            ->where('ActivoEnvio', '=', 1) 
            ->where('Estado', '=', 0) 
            ->where('Estado_T', '=', 2)   
            ->where('ID_OP_R', '=', $OficinaPartes->Id_OP)   
            ->where('DocFunc.ActivoEnvio', '=', 1)    
            ->orderBy('Fecha_T', $Orden) 
            ->paginate($this->perPage), 
  
            'FuncionariosAsig' =>  DB::table('LugarDeTrabajo') 
            ->leftjoin('Funcionarios', 'LugarDeTrabajo.ID_Funcionario_LDT', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('ID_Funcionario_T','Nombres','Apellidos') 
            ->where('ID_DepDirecciones_LDT', '=',$OficinaPartes->ID_OP_LDT)   
            ->where('Estado_LDT', '=', 1) 
            ->where('Subrogante', '=', 0) 
            ->get(),
             
            'MostrarDocumentos' =>  DB::table('Portafolio')  
            ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
            ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('Privado','ID_FSube','NombreDocumento','ID_DestinoDocumento','Nombres','Apellidos')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->get(),
             
            'DestinoPortafolio' =>  DB::table('InterPortaFuncionario') 
            ->leftjoin('Funcionarios', 'InterPortaFuncionario.IPF_ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('ID_Funcionario_T','FechaR','Visto','Estado','Observacion','ObservacionE','IPF_ID','Nombres','Apellidos') 
            ->where('Estado', '!=', 11) 
            ->where('Estado', '!=', 22)    
            ->where('IPF_Id_OP', '=',$OficinaPartes->Id_OP)   
            ->where('IPF_Portafolio', '=',$this->ID_Documento_T)  
            ->get(),

            'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
            ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select("Nombres","Apellidos")
            ->first(),


            'Subrogantes' =>  DB::table('Subrogante') 
            ->leftjoin('Funcionarios AS FuncionariosS', 'Subrogante.Id_Subrogante_S', '=', 'FuncionariosS.ID_Funcionario_T')
            ->leftjoin('Funcionarios AS FuncionariosO', 'Subrogante.Id_Subrogante_O', '=', 'FuncionariosO.ID_Funcionario_T')
            ->leftjoin('LugarDeTrabajo', 'FuncionariosO.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->select('Id_subrogante','FuncionariosS.ID_Funcionario_T as ID_Funcionario_TS','FuncionariosS.Nombres as NombresS','FuncionariosS.Apellidos as ApellidosS','FuncionariosO.Nombres as NombresO','FuncionariosO.Apellidos as ApellidosO') 
            ->where('ID_DepDirecciones_LDT', '=',$OficinaPartes->ID_OP_LDT)  
            ->where('Estado_LDT', '=', 1) 
            ->where('Subrogante.Activo', '=', 1) 
            ->get(),
        ]); 
    }
} 
 