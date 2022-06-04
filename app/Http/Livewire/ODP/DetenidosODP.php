<?php

namespace App\Http\Livewire\ODP;
use Livewire\Component;
use Livewire\WithPagination; 
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\Portafolio;
use App\Models\DocumentoFirma; 
use Illuminate\Support\Facades\Storage;
use App\Models\DestinoDocumento;
use App\Models\Documento;
use App\Models\InterPortaFuncionario;
use App\Models\LinkFirma;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarLink;   
use setasign\Fpdi\Fpdi;

 
class DetenidosODP extends Component
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

    //Pagina principal  
    public $Detalles=0;
    public $ID_Documento_T;
 
    public $Per_Subir;
    
    public $FuncionarioSelec;
  

    public function EnviarDocumento($ID_Documento_T,$ID_Funcionario){

        $this->FuncionarioSelec=$ID_Funcionario;
        $this->ID_Documento_T=$ID_Documento_T;
        $this->Detalles=2;
                 
    }
 
    public function EnviarCorreo($ID_LinkFirma){

        $DatosEmisor=DB::table('LinkFirma')->Select('Titulo_T','Nombres_L','Apellidos_L','Contenido','direccionEmail')->where('ID_LinkFirma','=', $ID_LinkFirma)->first();
 
        $Titulo = $DatosEmisor->Titulo_T; 
        $Nombres = $DatosEmisor->Nombres_L.' '.$DatosEmisor->Apellidos_L; 
        $Contenido = $DatosEmisor->Contenido; 
        $Email = $DatosEmisor->direccionEmail;  
    
        Mail::to($Email)->send(new EnviarLink($Titulo,$Nombres,$Contenido,$Email)); 

        $LinkFirma =LinkFirma::find($ID_LinkFirma);
        $LinkFirma->Email = 1;
        $LinkFirma->save();  
 
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

    public $EliminarPortafolio;
    public function EliminarPortafolio($ID_Documento_T){ 

        $this->EliminarPortafolio = $ID_Documento_T;
      
        $this->Detalles=3;

    }
 
    public $ContraseniaPortafolio;
    protected $EliminarFirmante = ['ContraseniaPortafolio' => 'required'];
    protected $MensajeEliminarFirmante = ['ContraseniaPortafolio.required' =>'El campo "Confirme Contraseña Usuario" es obligatorio.'];
    public function EliminarPortafolioConf(){

        $this->validate($this->EliminarFirmante,$this->MensajeEliminarFirmante); 

        $RUNInspector=Auth::guard('web')->user()->Rut;
        if(Auth::attempt(['Rut' => $RUNInspector, 'password' => $this->ContraseniaPortafolio], true)){ 
            
            $ID_OficinaPartes =  DB::table('Portafolio') 
            ->leftjoin('DestinoDocumento', 'Portafolio.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
            ->select('Ruta_T')
            ->where('DOC_ID_Documento', '=',$this->EliminarPortafolio)
            ->get();
    
            foreach ($ID_OficinaPartes as $Archivos) {   
     
                $codificado = Storage::disk('PDF')->delete($Archivos->Ruta_T);
                $codificado = Storage::disk('ImagenPDF')->delete($Archivos->Ruta_T);
                
            }   
 
            $VistoBueno =Portafolio::find($this->EliminarPortafolio);
            $VistoBueno->delete();  


            $LinkFirma =  DB::table('LinkFirma') 
            ->select('ID_LinkFirma')
            ->where('ID_Documento_L', '=',$this->EliminarPortafolio)
            ->get();
    
            foreach ($LinkFirma as $Link) {  
     
                $LinkFirma =LinkFirma::find($Link->ID_LinkFirma);
                $LinkFirma->delete();   
            } 


            $IPF_ID =  DB::table('InterPortaFuncionario') 
            ->select('IPF_ID')
            ->where('IPF_Portafolio', '=',$this->EliminarPortafolio)
            ->first();

            if(!empty($IPF_ID->IPF_ID)){
                $IPF_ID = $IPF_ID->IPF_ID;

                $InterPortaFuncionario =InterPortaFuncionario::find($IPF_ID);
                $InterPortaFuncionario->delete();
            }    

            session()->flash('message', 'Solicitud eliminada correctamente.');
            
            $this->Detalles=0;
            
            $this->ContraseniaPortafolio="";
        }
        else{
            $this->ContraseniaPortafolio="";
            
            session()->flash('message2', 'Contraseña incorrecta.');  
        }

    }

    
    public $MensajeRechazo; 
    public $Mostrar=0;
    public function MensajeRechazo($ID_Documento_T){

        $ObservacionE =  DB::table('InterPortaFuncionario')
        ->select('ObservacionE')
        ->where('IPF_Portafolio', '=',$ID_Documento_T)->first();

        session()->flash('message', $ObservacionE->ObservacionE);

        $this->Mostrar=1;


    }

    public $Funcionarios;
    public $IDEncargado2;
    public $NombreEncargado;
    public $ApellidoEncargado;
    public $cuantos;

    protected $paginationTheme = 'bootstrap'; 

    public function render()
    {

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;  

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

        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->select('ID_DepDirecciones_LDT')
        ->where('ID_Funcionario_T', '=',$ID_Funcionario)->first();

        $ID_DepDir = $DatosFirma->ID_DepDirecciones_LDT;

        $DatosEncargado =  DB::table('OficinaPartes') 
        ->leftjoin('Funcionarios', 'OficinaPartes.ID_Jefatura', '=', 'Funcionarios.ID_Funcionario_T') 
        ->select("ID_Funcionario_T","Nombres","Apellidos","Id_OP")->where('ID_OP_LDT', '=',$ID_DepDir)
        ->first();

        $Id_OP = $DatosEncargado->Id_OP;
        $this->NombreEncargado = $DatosEncargado->Nombres;
        $this->ApellidoEncargado = $DatosEncargado->Apellidos; 

        return view('livewire.o-d-p.detenidos-o-d-p',[
		'posts' =>  DB::table('Portafolio') 
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T') 
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->where(function($query) {  
                $query->orwhere('Estado_T', '=', 11)
                        ->orwhere('Estado_T', '=', 22)
                        ->orwhere('Estado_T', '=', 33)
                        ->orwhere('Estado_T', '=', 44)
                        ->orwhere('Estado_T', '=', 66);
                })   
            ->where(function($query) {  
                $query->orwhere('Folio', 'like', "%{$this->search}%")
                        ->orwhere('Titulo_T', 'like', "%{$this->search}%")
                        ->orwhere('Tipo_T', 'like', "%{$this->search}%") 
                        ->orwhere('Observacion_T', 'like', "%{$this->search}%");
                }) 
            ->where('ODP', '=', 1)           
            ->where('ID_OP_LDT_P', '=', $Id_OficinaParte->ID_OP_LDT) 
            ->orderBy('Estado_T', 'asc')
            ->paginate($this->perPage),
        
            'MostrarDocumentos' =>  DB::table('DestinoDocumento') 
            ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
            ->select('ID_FSube','ID_DestinoDocumento','NombreDocumento','ID_DocumentoFirma','ID_Documento','FechaFirma','Firmado')
            ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
            ->where('ID_Funcionario', '=',$this->FuncionarioSelec)->paginate(4),

            'LinkFirma' =>  DB::table('LinkFirma')
            ->select('ID_LinkFirma','ID_Funcionario_L','Nombres_L','Apellidos_L','Contenido','Estado','Email','direccionEmail')
            ->where('ID_Documento_L', '=', $this->ID_Documento_T)
            ->get(),

        ]);
    }
}
