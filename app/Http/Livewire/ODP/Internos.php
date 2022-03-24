<?php

namespace App\Http\Livewire\ODP;

use Livewire\Component;
use Livewire\WithPagination; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\DocFunc; 
use App\Models\CreDocFunc; 
use App\Models\VistoBueno;
use App\Models\DestinoDocumento;
use App\Models\Portafolio;
use App\Models\InterPortaFuncionario;
use App\Models\LinkFirma;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; 
class Internos extends Component 
{
    public $Ayuda=0; 
    
    public function Ayuda(){
        $this->Ayuda = 1;
    }
    public function VolverAyuda(){
        $this->Ayuda = 0;
    }
    
    use WithFileUploads;
    use WithPagination;   
    
    public $search; 
    public $perPage=5;
    public $Detalles=0;

    public function clear()
    {
      $this->search='';
      $this->perPage=5;
    } 

    public $ID_DocumentoEliminar;
    public $NombreEliminar;
    public $ApellidoEliminar;
    public function ConfirmarCancelarPortafolio($ID_Documento_T){

        $Datos =  DB::table('Portafolio')
        ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T') 
        ->select('Nombres','Apellidos')  
        ->where('ID_Documento_T', '=', $ID_Documento_T)->first();

        $this->ID_DocumentoEliminar = $ID_Documento_T;

        $this->NombreEliminar = $Datos->Nombres;
        $this->ApellidoEliminar = $Datos->Apellidos;

        $this->Detalles=1;

    }

    public $ID_Portafolio;
    public $ID_Documento_T;
    public function EnviarDocumento($ID_Documento_T){

        $this->ID_Portafolio=$ID_Documento_T;

        $this->ID_Documento_T=$ID_Documento_T;
          
        $this->Detalles=2;              
        
    }

    public $Contrasenia;
    protected $Eliminar = ['Contrasenia' => 'required'];
    protected $MensajeEliminar = ['Contrasenia.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    
    public function CancelarPortafolio(){
  
        $this->validate($this->Eliminar,$this->MensajeEliminar); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->Contrasenia], true))
        { 
            $ID_OficinaPartes =  DB::table('Portafolio') 
            ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
            ->select('Ruta_T')
            ->where('DOC_ID_Documento', '=',$this->ID_DocumentoEliminar)
            ->get();
     
            foreach ($ID_OficinaPartes as $Archivos) {  
    
                $codificado = Storage::disk('PDF')->delete($Archivos->Ruta_T); 
                $codificado = Storage::disk('ImagenPDF')->delete($Archivos->Ruta_T);
                
            }

            $LinkFirma =  DB::table('LinkFirma') 
            ->select('ID_LinkFirma')
            ->where('ID_Documento_L', '=',$this->ID_DocumentoEliminar)
            ->get();
    
            foreach ($LinkFirma as $Link) {  
     
                $LinkFirma =LinkFirma::find($Link->ID_LinkFirma);
                $LinkFirma->delete();   
            } 


            $ID_IPF_Portafolio  =  DB::table('InterPortaFuncionario') 
            ->select('IPF_ID')
            ->where('IPF_Portafolio', '=',$this->ID_DocumentoEliminar)
            ->first();


            if(!empty($ID_IPF_Portafolio)){ 

                $InterPortaFuncionario =InterPortaFuncionario::find($ID_IPF_Portafolio->IPF_ID);
                $InterPortaFuncionario->delete();
            
            }
           
 
            $Portafolio =Portafolio::find($this->ID_DocumentoEliminar);
            $Portafolio->delete();
            
            $this->Detalles=0;
            session()->flash('message', 'Eliminado correctamente.');  
        }
        else{
            session()->flash('message2', 'Contraseña incorrecta.');  
        }

        $this->Contrasenia='';   
    }

  
    public $BuscarOficinaPartes=""; 
    public $NombreOficinaParte;
    public $Id_OP_Receptor;
    public $ID_DepDir=0;

    public function OficinaPartesSeleccionada($ID_DepDir){

        $NombreOficinaParte =  DB::table('DepDirecciones')
        ->select('Nombre_DepDir')
        ->where('ID_DepDir', '=', $ID_DepDir)->first();

        $this->NombreOficinaParte=$NombreOficinaParte->Nombre_DepDir;

        $this->ID_DepDir = $ID_DepDir;
        $this->BuscarOficinaPartes = "";

    }

    public $TipoEnvio;
    public $ObservacionPortafolio;

    protected $rulesEnviarPortafolio = ['TipoEnvio' => 'required',
                                        'NombreOficinaParte' => 'required'];

    protected $messEnviarPortafolio = [ 'TipoEnvio.required' =>'El campo "TIPO DE ENVIO" es obligatorio.',
                                        'NombreOficinaParte.required' =>'El campo "SELECCIONAR OFICINA DE PARTES" es obligatorio.'];

    public function EnviarPortafolio(){

        $Activado =  DB::table('OficinaPartes')
        ->where('ID_OP_LDT', '=', $this->ID_DepDir)->first();

        $this->validate($this->rulesEnviarPortafolio,$this->messEnviarPortafolio); 

        if(!empty($Activado->id_Funcionario_OP) || !empty($Activado->ID_Jefatura)){

            $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
    
            $OficinaPartes =  DB::table('Funcionarios')
            ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP') 
            ->select('Id_OP')  
            ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first();

            $Seleccionado =  DB::table('DepDirecciones')
            ->leftjoin('OficinaPartes', 'DepDirecciones.ID_DepDir', '=', 'OficinaPartes.ID_OP_LDT')
            ->select('Id_OP')
            ->where('ID_DepDir', '=', $this->ID_DepDir)->first();
    
            $Id_OP_Receptor=$Seleccionado->Id_OP;
     
            if($this->TipoEnvio==1){
        
                $DocFunc                    = new DocFunc;
                $DocFunc->ID_OP_E           = $OficinaPartes->Id_OP; 
                $DocFunc->ID_OP_R           = $Id_OP_Receptor; 
                $DocFunc->ID_Documento      = $this->ID_Documento_T;
                $DocFunc->ActivoEnvio       = 1;
                $DocFunc->FechaR            = date("Y/m/d"); 
                $DocFunc->Estado            = 0;
                $DocFunc->Visto             = 0;
                $DocFunc->Mensaje_E         =$this->ObservacionPortafolio;
                $DocFunc->save();
        
        
                
                $Portafolio =Portafolio::find($this->ID_Portafolio);
                $Portafolio->Estado_T  =  2;
                $Portafolio->save(); 
        
        
        
                $this->Destinatarios="";
                $this->ObservacionE="";
                session()->flash('message4', 'Envio agregado correctamente.');
        
                $this->Detalles=2;
    
            }
            else{
        
                $VistoBueno                      = new VistoBueno;
                $VistoBueno->ID_OP_E             = $OficinaPartes->Id_OP;
                $VistoBueno->ID_OP_R             = $Id_OP_Receptor; 
                $VistoBueno->ID_Documento        = $this->ID_Documento_T;
                $VistoBueno->Estado              = 0;
                $VistoBueno->Visto               = 0;  
                $VistoBueno->Fecha               = date("Y/m/d");  
                $VistoBueno->ObservacionE        = $this->ObservacionPortafolio;  
                $VistoBueno->save(); 
            } 
    
            $this->TipoEnvio="";
            $this->DestinoFuncionario="";
            $this->ObservacionPortafolio="";
            $this->NombreOficinaParte="";
    
            session()->flash('message4', 'Enviado correctamente.');  

        }
        else{
            session()->flash('message3', 'Destino no habilitado actualmente en el sistema.');  
        } 
    }

    public $Nombre_DepDir; 
    public $ApellidosAviso;
    public $ID_Aviso_T;
    public function AnularAviso($ID_Aviso_T){ 

        $this->ID_Aviso_T = $ID_Aviso_T;

        $VistoBueno =  DB::table('VistoBueno') 
        ->leftjoin('OficinaPartes','VistoBueno.ID_OP_R','=','OficinaPartes.Id_OP')
        ->leftjoin('DepDirecciones','OficinaPartes.ID_OP_LDT','=','DepDirecciones.ID_DepDir')
        ->select('Nombre_DepDir')
        ->where('ID_Aviso_T', '=',$ID_Aviso_T)->first();

        $this->Nombre_DepDir  = $VistoBueno->Nombre_DepDir;
        
        $this->Detalles=3;

    }

    public function ConfirmarAnularAviso(){

        $VistoBueno =VistoBueno::find($this->ID_Aviso_T);
        $VistoBueno->delete(); 
        session()->flash('message', 'Visto bueno eliminado correctamente.');
        $this->Detalles=6;

    }


    public $ContraseniaVB;
    protected $EliminarVB = ['ContraseniaVB' => 'required'];
    protected $MensajeEliminarVB = ['ContraseniaVB.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    public function CancelarVB(){

        $this->validate($this->EliminarVB,$this->MensajeEliminarVB); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaVB], true)){ 

            $VistoBueno =  DB::table('VistoBueno') 
            ->select('ID_Aviso_T')
            ->where('ID_Documento', '=',$this->ID_Documento_T)->first();

            $ID_Aviso_T  = $VistoBueno->ID_Aviso_T;

            $VistoBueno =VistoBueno::find($ID_Aviso_T);
            $VistoBueno->delete(); 
            session()->flash('message', 'Visto bueno eliminado correctamente.');
            $this->Detalles=2;

            $this->ContraseniaVB="";
        }
        else{
            $this->ContraseniaVB="";
            session()->flash('message2', 'Contraseña incorrecta.');  
        }

    }

    public $AnularFirmante;
    public $NombreAnularFirmante;
    public function AnularFirmante($ID_IntDocFunc,$ID_OP_R){ 

        $this->AnularFirmante = $ID_IntDocFunc;
        $this->NombreAnularFirmante = $ID_OP_R;

        $Firmante =  DB::table('OficinaPartes') 
        ->leftjoin('DepDirecciones','OficinaPartes.ID_OP_LDT','=','DepDirecciones.ID_DepDir')
        ->select('Nombre_DepDir')
        ->where('Id_OP', '=',$ID_OP_R)->first();

        $this->NombreAnularFirmante  = $Firmante->Nombre_DepDir;
        
        $this->Detalles=4;

    }

    public function ConfirmarFinalizarPortafolio(){
        $this->Detalles=5;
    }

    public function FinalizarPortafolio(){  

        $ComprobarFinalizar =  DB::table('DocFunc')
        ->select('ID_IntDocFunc') 
        ->where(function($query) {  
            $query->orwhere('Estado', '=', 0)
                ->orwhere('Estado', '=', 1);
        }) 
        ->where('ID_Documento', '=',  $this->ID_Documento_T)->get();

        if(!empty($ComprobarFinalizar)){

            $NumeroRechazo = count($ComprobarFinalizar); 

            if($NumeroRechazo==0)  
            {

                $Portafolio =Portafolio::find($this->ID_Documento_T);
                $Portafolio->Estado_T     = 4;
                $Portafolio->save();

                $ID_OficinaPartes =  DB::table('Portafolio') 
                ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
                ->select('Ruta_T')
                ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
                ->get();
        
                foreach ($ID_OficinaPartes as $Archivos) {  
        
                    $codificado = Storage::disk('ImagenPDF')->delete($Archivos->Ruta_T);
                    
                }  

                $this->Detalles=0;
            }
            else{

                $ComprobarFinalizar =  DB::table('Portafolio')
                ->leftjoin('InterPortaFuncionario', 'Portafolio.ID_Documento_T', '=', 'InterPortaFuncionario.IPF_Portafolio') 
                ->select('IPF_Id_OP')  
                ->where(function($query) {
                    $query->orwhere('Estado', '=', 1)
                            ->orwhere('Estado', '=', 2);
                }) 
                ->where('IPF_Portafolio', '=',  $this->ID_Documento_T)->get();

                $Numero = count($ComprobarFinalizar); 

                if($Numero>=1){
                    
                    $Portafolio =Portafolio::find($this->ID_Documento_T);
                    $Portafolio->Estado_T     = 3;
                    $Portafolio->save();

                    $ID_OficinaPartes =  DB::table('Portafolio') 
                    ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
                    ->select('Ruta_T')
                    ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
                    ->get();
            
                    foreach ($ID_OficinaPartes as $Archivos) {  
            
                        $codificado = Storage::disk('ImagenPDF')->delete($Archivos->Ruta_T);
                        
                    }  

                    $this->Detalles=0;

                }else{
                    session()->flash('message4', 'Para finalizar una solicitud debe existir al menos un firmante, y que haya aceptado o rechazado tal solicitud.');  
                }

            }
 
        }
        else{
            session()->flash('message4', 'Para finalizar una solicitud debe existir al menos un firmante, y que haya aceptado o rechazado tal solicitud.');  
        }

    } 


    public $ContraseniaFirmante;
    protected $EliminarFirmante = ['ContraseniaFirmante' => 'required'];
    protected $MensajeEliminarFirmante = ['ContraseniaFirmante.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    public function CancelarFirmante(){


        $this->validate($this->EliminarFirmante,$this->MensajeEliminarFirmante); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaFirmante], true)){ 
            
            $VistoBueno =DocFunc::find($this->AnularFirmante);
            $VistoBueno->delete(); 
            session()->flash('message', 'Firmante eliminado correctamente.');
            $this->Detalles=2;
            
            $this->ContraseniaFirmante="";
        }
        else{
            $this->ContraseniaFirmante="";
            session()->flash('message2', 'Contraseña incorrecta.');  
        }

    }

    public function VolverPrincipal(){
        $this->Detalles=0;
        $this->resetPage();  
        $this->resetErrorBag(); 
    } 


    public $OficinaPartes; 


    public function VolverAnular(){
        $this->Detalles=2;
    }

    public $IDAnular;
    public $Nombre_DepDirAnular;
    
    public function AsignarIDAnular($ID_IntDocFunc){

        $this->IDAnular=$ID_IntDocFunc;

        $Datos =  DB::table('DocFunc') 
        ->leftjoin('OficinaPartes', 'DocFunc.ID_OP_R', '=', 'OficinaPartes.Id_OP')
        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
        ->select('Nombre_DepDir')
        ->where('ID_Documento', '=',$this->ID_Documento_T)->first();

         
            $this->Nombre_DepDirAnular = $Datos->Nombre_DepDir;
   
          $this->Detalles=5; 
    
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

    protected $paginationTheme = 'bootstrap';  
    public $Orden;

    public function render() 
    {
        if($this->Orden==1){
            $Orden='ASC';
        }else{
            $Orden='DESC';
        }


        $this->OficinaPartes =  DB::table('DepDirecciones')
        ->leftjoin('OficinaPartes', 'DepDirecciones.ID_DepDir', '=', 'OficinaPartes.ID_OP_LDT')
        ->where('Nombre_DepDir', 'like', "%{$this->BuscarOficinaPartes}%")->take(3)->get();
       

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
        
     
        $Id_OficinaParte =  DB::table('OficinaPartes')
        ->select('Id_OP')
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first(); 

        $OficinaPartes =  DB::table('Funcionarios')
        ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP') 
        ->select('Id_OP','ID_OP_LDT')  
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first();

        return view('livewire.o-d-p.internos',[  

			'posts' =>  DB::table('Portafolio')  
                ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
                ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
                ->where(function($query) {  
                    $query->orwhere('Estado_T', '=', 1)
                        ->orwhere('Estado_T', '=', 2);
                })       
                ->where(function($query) {  
                    $query->orwhere('NumeroInterno', 'like', "%{$this->search}%")
                        ->orwhere('Folio', 'like', "%{$this->search}%")
                        ->orwhere('Titulo_T', 'like', "%{$this->search}%")
                        ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                        ->orwhere('Observacion_T', 'like', "%{$this->search}%");
                })  
                ->where('ID_OficinaP', '=', $Id_OficinaParte->Id_OP)     
                ->orderBy('Fecha_T', $Orden)
                ->paginate($this->perPage),  

                'MostrarDocumentos' =>  DB::table('Portafolio')  
                ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
                ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
                ->select('Privado','ID_FSube','NombreDocumento','ID_DestinoDocumento','Nombres','Apellidos')
                ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->get(),
                
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

                'MostrarDocumentos2' =>  DB::table('DestinoDocumento') 
                ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
                ->select('ID_DocumentoFirma')
                ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
                ->where('ID_Funcionario', '=',$ID_Funcionario)->get(),

                'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
                ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
                ->select("Nombres","Apellidos")
                ->first(),
        ]);
    }
}
 