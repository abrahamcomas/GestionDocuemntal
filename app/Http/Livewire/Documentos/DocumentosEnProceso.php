<?php

namespace App\Http\Livewire\Documentos;

use Livewire\Component;
use Livewire\WithPagination; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\DocFunc;
use App\Models\CreDocFunc;
use App\Models\DocumentoFirma;
use App\Models\AvisoDocumento;

class DocumentosEnProceso extends Component
{



  public $ID_Documento_T;

  public $ObservacionR;
  public function FirmarDocumento($ID_Documento_T){
    $this->ID_Documento_T=$ID_Documento_T;
    $this->Detalles='1';
   }


 
 




    
    use WithPagination;  
    public $search; 
    public $perPage = '5';
    public $M_Detalles;
    public $Id_Multas; 
    public $Datos; 
    public $Testigo;
    public $Detalles='0';
    public $ObservacionE; 
    public $Destinatarios;
    

      
    
    
      public $IDAnular;
      public $NombresAnular;
      public $ApellidosAnular;
      public function AsignarIDAnular($ID_IntDocFunc){

        $this->IDAnular=$ID_IntDocFunc;

        $Datos =  DB::table('DocFunc') 
        ->leftjoin('Funcionarios', 'DocFunc.ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
        ->select('Nombres','Apellidos')
        ->where('ID_Documento', '=',$this->ID_Documento_T)->get();

          foreach ($Datos as $user){
            $this->NombresAnular = $user->Nombres;
            $this->ApellidosAnular = $user->Apellidos;
          } 

      }

      public function AnularEnvio()
      {
        $this->Detalles='3';

        
       
        $DocFunc =DocFunc::find($this->IDAnular);
        $DocFunc->delete();
       
        
        session()->flash('message2', 'Envio anulado a '.  $this->NombresAnular.' '.$this->ApellidosAnular);
       
       }
          



public function VolverPrincipal(){

      $this->Detalles='0';
      $this->resetPage();
      $this->resetErrorBag();
    }

    public function Derivar($ID_Documento_T)
    {
      $this->Detalles='3';

      $this->ID_Documento_T=$ID_Documento_T;

    


     }
  


     protected $rules = ['Destinatarios' => 'required'];

	protected $messages = ['Destinatarios.required' =>'El campo Enviar es obligatorio.'];
     public function AsignarDerivacion()
     {
      $this->validate(); 
      $this->Detalles='3';
  

      $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

          $UltimoActivo =  DB::table('DocFunc')
          ->select('ID_IntDocFunc')
          ->where('ID_Funcionario', '=', $this->Destinatarios)
          ->where('ID_Documento', '=', $this->ID_Documento_T)
          ->where('FechaE', '=', NULL)->get()->last();

          if(!empty($UltimoActivo))
          {

            $UltimoDesactivado =DocFunc::find($UltimoActivo->ID_IntDocFunc);
            $UltimoDesactivado->ActivoEnvio      =  0;
            $UltimoDesactivado->save();
          
           
          }
    
          $DocFunc                   = new DocFunc;
          $DocFunc->ID_Funcionario   = $this->Destinatarios;
          $DocFunc->ID_Documento     = $this->ID_Documento_T;
          $DocFunc->Asignador        = $ID_Funcionario;
          $DocFunc->ActivoEnvio      = 1;
          $DocFunc->FechaR           = date("Y/m/d"); 
          $DocFunc->Estado           = '0';
          $DocFunc->Visto            = '0';
          $DocFunc->Mensaje_Cre      =$this->ObservacionR;
          $DocFunc->save();

          
 




 


 

          $VerificarFirma =  DB::table('DocumentoFirma')
          ->where('ID_Funcionario', '=', $this->Destinatarios)
          ->where('ID_Documento', '=', $this->ID_Documento_T)->first();

      

          if(!$VerificarFirma)
          {

            $DocumentoFirma                   = new DocumentoFirma;
            $DocumentoFirma->ID_Funcionario   = $this->Destinatarios;
            $DocumentoFirma->ID_Documento     = $this->ID_Documento_T;
            $DocumentoFirma->Firmado          = 0; 
            $DocumentoFirma->save();
          
          
          }




    

  
















      
          $CreDocFunc                     = new CreDocFunc;
          $CreDocFunc->Id_DocFunc_Cre     =  $DocFunc->ID_IntDocFunc;
          $CreDocFunc->ID_Funcionario_Cre = $ID_Funcionario;
          $CreDocFunc->Mensaje_Cre        = $this->ObservacionR;
          $CreDocFunc->save();
          

          $this->Destinatarios="";
          $this->ObservacionR="";
          session()->flash('message', 'Envio agregado correctamente.');

        

      


 
      
      
      }

public function VolverAvisos(){

  
  $this->Detalles='3';
}





        public function AdministrarAvisos(){

    
          $this->Detalles='2';



        }
        protected $rules2 = ['DestinatariosVistos' => 'required'];

        protected $messages2 = ['DestinatariosVistos.required' =>'El campo Enviar es obligatorio.'];

        public $ObservacionVisto;
        public $DestinatariosVistos;
        public function Avisar(){ 

        

          $this->validate($this->rules2,$this->messages2); 

          $this->Detalles='2';

          $AvisoDocumento                   = new AvisoDocumento;
          $AvisoDocumento->ID_Funcionario   = $this->DestinatariosVistos;
          $AvisoDocumento->ID_Documento     = $this->ID_Documento_T;
          $AvisoDocumento->Visto        = 0;
          $AvisoDocumento->Observacion          =$this->ObservacionVisto;     
          $AvisoDocumento->save();


          $this->DestinatariosVistos="";
          $this->ObservacionVisto="";

          session()->flash('message', 'Aviso agregado correctamente.');

        }





public $NombresAviso;
public $ApellidosAviso;
public $ID_Aviso_T;
public function AnularAviso($ID_Aviso_T){

  $this->ID_Aviso_T = $ID_Aviso_T;

  $AvisoDocumento =  DB::table('AvisoDocumento') 
  ->leftjoin('Funcionarios', 'AvisoDocumento.ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
  ->where('ID_Aviso_T', '=',$ID_Aviso_T)->get();

    foreach ($AvisoDocumento as $user){
      $this->NombresAviso = $user->Nombres;
      $this->ApellidosAviso = $user->Apellidos;
    }



}
public function ConfirmarAnularAviso(){


  $AvisoDocumento =AvisoDocumento::find($this->ID_Aviso_T);
  $AvisoDocumento->delete();
  $this->Detalles='2';

}



















    
 

public $Funcionarios;
public $TipoFirma;

  protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
        $this->Funcionarios =  DB::table('Funcionarios')->get();


        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
 
        $this->TipoFirma =  DB::table('Funcionarios')
        ->select('TipoFirma')
        ->where('ID_Funcionario_T', '=', $ID_Funcionario)->get();

 
        return view('livewire.documentos.documentos-en-proceso',[

			  'posts' =>  DB::table('Documento') 
          ->leftjoin('TipoDocumento', 'Documento.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
          ->leftjoin('DocumentoFirma', 'Documento.ID_Documento_T', '=', 'DocumentoFirma.ID_Documento')
          ->where('Estado_T', '=', 0)
          ->where(function($query) {
                $query->orwhere('Titulo_T', 'like', "%{$this->search}%")
                      ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                      ->orwhere('Observacion_T', 'like', "%{$this->search}%");
          })         
          ->where('ID_Funcionario_Sol', '=', $ID_Funcionario)   
          ->where('DocumentoFirma.ID_Funcionario', '=', $ID_Funcionario)      
          ->paginate($this->perPage),
          'FuncionariosAsig' =>  DB::table('DocFunc') 
          ->leftjoin('Funcionarios', 'DocFunc.ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
          ->where('ID_Documento', '=',$this->ID_Documento_T) 
          ->paginate(4),
          'FuncionariosAvisos' =>  DB::table('AvisoDocumento') 
          ->leftjoin('Funcionarios', 'AvisoDocumento.ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
          ->where('ID_Documento', '=',$this->ID_Documento_T) 
          ->paginate(4)
        ]);
    }
}
  