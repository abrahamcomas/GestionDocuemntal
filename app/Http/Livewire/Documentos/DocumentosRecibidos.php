<?php

namespace App\Http\Livewire\Documentos;

use Livewire\Component; 
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\DocFunc;
use App\Models\Documento;
use App\Models\CreDocFunc; 
use App\Models\DocumentoFirma; 
use Illuminate\Support\Facades\Storage;
use App\Models\DestinoDocumento;

class DocumentosRecibidos extends Component
{
    use WithPagination;  
    use WithFileUploads;  
    public $search; 
    public $perPage = 5; 
    //Pagina principal 
    public $Detalles=0;
    public $ID_Documento_T;
    public $Destinatarios;

    public $Per_Subir;
    public $OriginalID_Funcionario_Sol;
    public $ID_IntDocFunc;
    public function Responder($ID_IntDocFunc,$ID_Documento_T){
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
                
        $DocFunc =DocFunc::find($ID_IntDocFunc);
        $DocFunc->Visto        = 1;
        $DocFunc->Fecha_V      = date("Y/m/d");
        $DocFunc->save();

        $this->ID_Documento_T=$ID_Documento_T;
        $this->ID_IntDocFunc=$ID_IntDocFunc;
        $this->Detalles=4;
    }

    public function Solicitar(){
        $this->Detalles=2;

    } 




   
    public function VolverPrincipal(){
        $this->Opciones=0;
           $this->Detalles=0;
           $this->resetPage();
           $this->resetErrorBag(); 
    }

    



    
    public $Mensaje_R;
    public function SolicitudArchivo(){ 
        $Documento =Documento::find($this->ID_Documento_T);
        $Documento->Estado_T         = 2;
        $Documento->save();

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
        
        $DocFunc =DocFunc::find($this->ID_IntDocFunc);
        $DocFunc->Estado          = 2;
        $DocFunc->Mensaje_R       = $this->Mensaje_R ;
        $DocFunc->save();
        $this->Detalles=0;
    }






























    
    
    public function ListaDocumentos($ID_Documento_T){ 

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 
                
        $Datos =  DB::table('DocFunc') 
            ->select('ID_IntDocFunc')
            ->where('ID_Documento', '=',$ID_Documento_T)
            ->where('ID_FuncionarioR', '=',$ID_Funcionario)
            ->where('ActivoEnvio', '=',1)->get();

              foreach ($Datos as $user){
                $ID_IntDocFunc   = $user->ID_IntDocFunc ;
              } 
        $DocFunc =DocFunc::find($ID_IntDocFunc);
        $DocFunc->Visto        = 1;
        $DocFunc->Fecha_V      = date("Y/m/d");
        $DocFunc->save();

        $Original =  DB::table('Documento') 
        ->select('ID_Funcionario_Sol')->where('ID_Documento_T', '=',$ID_Documento_T)->first();

        $this->OriginalID_Funcionario_Sol=$Original->ID_Funcionario_Sol;

     
        
        $TotalDocumentos =  DB::table('Documento') 
        ->leftjoin('DestinoDocumento', 'Documento.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
        ->where('ID_Funcionario_Sol', '=',$ID_Funcionario)
        ->where('ID_Documento_T', '=',$ID_Documento_T)
        ->get();
         
        $Total= count($TotalDocumentos);
        
        $DocumentosFirmados =  DB::table('Documento') 
        ->leftjoin('DestinoDocumento', 'Documento.ID_Documento_T', '=', 'DestinoDocumento.DOC_ID_Documento')
        ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
        ->select('Firmado')
        ->where('ID_Funcionario_Sol', '=',$ID_Funcionario)
        ->where('ID_Documento_T', '=',$ID_Documento_T)
        ->where('Firmado', '=', 1)
        ->get();

        $TotalFirmados= count($DocumentosFirmados);
        
        if($Total==$TotalFirmados){
            $this->Per_Subir=0;
        }
        else{

            $this->Per_Subir=1;
        }

        $this->ID_Documento_T=$ID_Documento_T;
        $this->Detalles=2;
        
    }

    public $PDF= [];
    protected $rules3 = ['PDF' => 'required'];
    protected $messages3 = ['PDF.required' =>'El campo ARCHIVO/S es obligatorio.'];
    public function Ingresar(){ 
        
        $this->validate($this->rules3,$this->messages3); 
        $Funcionario  =  Auth::user()->ID_Funcionario_T;
               
        foreach ($this->PDF as $Archivos) { 
                   $codificado = Storage::disk('PDF')->put('', $Archivos);
   
                   $DestinoDocumento                    = new DestinoDocumento;
                   $DestinoDocumento->ID_FSube         = $Funcionario;
                   $DestinoDocumento->DOC_ID_Documento = $this->ID_Documento_T;
                   $DestinoDocumento->NombreDocumento  = $Archivos->getClientOriginalName(); 
                   $DestinoDocumento->Ruta_T           = $codificado;  
                   $DestinoDocumento->save();
   
                   $DocumentoFirma                  = new DocumentoFirma;
                   $DocumentoFirma->ID_Funcionario  = $Funcionario;
                   $DocumentoFirma->ID_Documento    = $DestinoDocumento->ID_DestinoDocumento;  
                   $DocumentoFirma->Firmado         = 0;  
                   $DocumentoFirma->save();  
        }
        session()->flash('message', 'Archivo agregado correctamente.');      
    }

    //Boton datatable firmar documento     
    public $ID_DestinoDocumento;
    public function FirmarDocumento($ID_DestinoDocumento){
        $this->ID_DestinoDocumento=$ID_DestinoDocumento;
        $this->Detalles=3;
       
    }

    public function FirmarDocumento2($ID_DestinoDocumento){
        $this->ID_DestinoDocumento=$ID_DestinoDocumento;
        $this->Detalles='FirmaOpcional';
       
    }
       
    public function EliminarDocumento($ID_DestinoDocumento)
       { 
           $VistoBueno =  DB::table('DestinoDocumento')->select('Ruta_T') 
           ->where('ID_DestinoDocumento', '=',$ID_DestinoDocumento)->first();
   
   
           $codificado = Storage::disk('PDF')->delete($VistoBueno->Ruta_T);
               
               $DestinoDocumento                   = DestinoDocumento::find($ID_DestinoDocumento);
               $DestinoDocumento->delete();
    
               $this->resetPage();
                 
               if($DestinoDocumento){
                   session()->flash('message', 'Archivo eliminado correctamente.');
   
               }
               else{
   
                   session()->flash('message2', 'Error al eliminar archivo.');
               }
              
       }
        //Boton datatable Enviar Documento  
        public function Opciones($ID_Documento_T)
        { 
          $this->Detalles='4';
          $this->ID_Documento_T=$ID_Documento_T;

          $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
        
          $Datos =  DB::table('DocFunc') 
              ->select('ID_IntDocFunc') 
              ->where('ID_FuncionarioR', '=',$ID_Funcionario) 
              ->where('ID_Documento', '=',$ID_Documento_T)->get();

                foreach ($Datos as $user){
                  $ID_IntDocFunc  = $user->ID_IntDocFunc;
                } 


      
               
         
          $DocFunc =DocFunc::find($ID_IntDocFunc);
          $DocFunc->Visto        = 1;
          $DocFunc->Fecha_V            = date("Y/m/d");
          $DocFunc->save();
        }
   











    //Aceptar Documento 
    public $ObservacionAceptado;
    public function AceptarDocumento(){ 
    

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $VerFirma =  DB::table('DocumentoFirma')  
        ->leftjoin('DestinoDocumento', 'DocumentoFirma.ID_Documento', '=', 'DestinoDocumento.ID_DestinoDocumento')
        ->select('Firmado')
        ->where('ID_Funcionario', '=',$ID_Funcionario)
        ->where('DOC_ID_Documento', '=',$this->ID_Documento_T) 
        ->where('Firmado', '=',0)->get();

        $TotalFirmados= count($VerFirma);

        if($TotalFirmados==0){     

            $Datos =  DB::table('DocFunc')
            ->where('ID_FuncionarioR', '=',$ID_Funcionario)
            ->where('ID_Documento', '=',$this->ID_Documento_T)
            ->where('FechaE', '=',NULL)->first();


            $DocFunc =DocFunc::find($Datos->ID_IntDocFunc);
            $DocFunc->FechaE         = date("Y/m/d");
            $DocFunc->Estado         = 1;
            $DocFunc->Mensaje_R      = $this->ObservacionAceptado;
            $DocFunc->save();  


            
            $VerSiFinaliza =  DB::table('Documento') 
            ->leftjoin('DocFunc', 'Documento.ID_Documento_T', '=', 'DocFunc.ID_Documento')
            ->select('Estado')
            ->where('ID_Documento_T', '=',$this->ID_Documento_T)
            ->where('Estado', '=',0)->get();

            $TotalVerSiFinaliza= count($VerSiFinaliza);

            if($TotalVerSiFinaliza==0){     
                $DocFunc =Documento::find($this->ID_Documento_T);
                $DocFunc->Estado_T          = 3;
                $DocFunc->save();  
            }


            $this->Detalles=0;
            $this->resetPage();
            $this->resetErrorBag();

        }
                
        else{
            session()->flash('messageFinalizado', 'Para aceptar una solicitud, primero debe firmar sus archivos.');
        }

    }


    public function DocumentosSubidosTotal(){
        $this->Detalles='DocumentosSubidosTotal';

    }

    public function VolverListaDocumentos(){

        $this->Detalles=4;
    }
































             

               

       
              


              

                public function SoloAceptar(){ 



                  $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
                 
                

                    
                  
                       
                      $Buscar_ID_IntDocFunc  =  DB::table('Documento') 
                      ->leftjoin('DocFunc', 'Documento.ID_Documento_T', '=', 'DocFunc.ID_Documento')
                      ->where('ID_Documento', '=',$this->ID_Documento_T)
                      ->where('FechaE', '=',NULL)
                      ->where('ID_Funcionario', '=',$ID_Funcionario)->get();
                      
                      
                      foreach ($Buscar_ID_IntDocFunc as $user){
                          $ID_IntDocFunc  = $user->ID_IntDocFunc;
                
                        }
                 
                        
               
                       

                    $DocFunc =DocFunc::find($ID_IntDocFunc);
                    $DocFunc->FechaE         = date("Y/m/d");
                    $DocFunc->Estado         = 4;
                    $DocFunc->save();
                 
                    $this->Detalles='0';
                    $this->resetPage();
                    $this->resetErrorBag();






















                 }




 
 

                public function RechazarDocumento(){ 
                 

                  $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

                  $Datos =  DB::table('DocFunc') 
                  ->select('ID_IntDocFunc')
                  ->where('ID_Documento', '=',$this->ID_Documento_T)
                  ->where('ID_FuncionarioR', '=',$ID_Funcionario)
                  ->where('ActivoEnvio', '=',1)->get();
      
                    foreach ($Datos as $user){
                      $ID_IntDocFunc   = $user->ID_IntDocFunc ;
                    }
                 
                        
                        $Documento =Documento::find($this->ID_Documento_T);
                        $Documento->Estado_T            = 4;
                        $Documento->save(); 
                        

                    $DocFunc =DocFunc::find($ID_IntDocFunc);
                    $DocFunc->FechaE         = date("Y/m/d");
                    $DocFunc->Estado         = 4;
                    $DocFunc->save();
                    
                 
                    $this->Detalles='0';
                    $this->resetPage();
                    $this->resetErrorBag();

                  }
                       
                 
                
                
                
                


                  public function clear()
                  {
                    $this->search='';
                    $this->perPage='5';
                  }












                
                
                
                
                
                
                
                
                
             
                
       
                public $ObservacionEAbajo; 
                public $OpcionFirma; 
                protected $rules = ['Destinatarios' => 'required'];
                protected $messages = ['Destinatarios.required' =>'El campo Enviar es obligatorio.'];
                
                public function EnviarDocumento() 
                {
                   
                    $this->validate(); 

                    $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

                    $VerFirma =  DB::table('DestinoDocumento') 
                    ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
                    ->select('Firmado')
                    ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
                    ->where('ID_FSube', '=',$ID_Funcionario)
                    ->where('Firmado', '=', 0)
                    ->get(); 
            
                    $TotalFirmados= count($VerFirma);
             
                    if(!empty($TotalFirmados==0)){ 
                    
                        // Varriable general al apretar opciones ID_Documento_T               
                        $DocumentosOriginales =  DB::table('Documento')
                            ->select('ID_Funcionario_Sol')
                            ->where('ID_Documento_T', '=',$this->ID_Documento_T)->first();
                        
                        $ID_Funcionario_Sol   = $DocumentosOriginales->ID_Funcionario_Sol;

                        $DestinoDocumento =  DB::table('DestinoDocumento') 
                            ->select('ID_DestinoDocumento')
                            ->where('ID_FSube', '=',$ID_Funcionario_Sol)->get();
                                
                            foreach ($DestinoDocumento as $user){
                            
                                $DocumentoFirma                   = new DocumentoFirma;
                                $DocumentoFirma->ID_Funcionario   = $this->Destinatarios;
                                $DocumentoFirma->ID_Documento     = $user->ID_DestinoDocumento;
                                $DocumentoFirma->Firmado          = '0';
                                $DocumentoFirma->save();
                            
                            }

                            $UltimoActivo =  DB::table('DocFunc')
                                ->select('ID_IntDocFunc')
                                ->where('ID_FuncionarioR', '=', $this->Destinatarios)
                                ->where('ID_Documento', '=', $this->ID_Documento_T)
                                ->where('FechaE', '=', NULL)->get()->last();
                                
                            if(!empty($UltimoActivo))
                                { 
                                
                                    $UltimoDesactivado =DocFunc::find($UltimoActivo->ID_IntDocFunc);
                                    $UltimoDesactivado->ActivoEnvio      =  0;
                                    $UltimoDesactivado->save();
                                            
                                              
                                } 
                                    
                                $DocFunc                   = new DocFunc;
                                $DocFunc->ID_FuncionarioE  = $ID_Funcionario;
                                $DocFunc->ID_FuncionarioR  = $this->Destinatarios;
                                $DocFunc->ID_Documento     = $this->ID_Documento_T;
                                $DocFunc->ActivoEnvio      = 1;
                                $DocFunc->FechaR           = date("Y/m/d"); 
                                $DocFunc->Estado           = '0';
                                $DocFunc->Visto            = '0';
                                $DocFunc->Mensaje_E       =$this->ObservacionEAbajo;
                                $DocFunc->save();


                                $UltimoActivoQueEnvia =  DB::table('DocFunc')
                                ->select('ID_IntDocFunc')
                                ->where('ID_FuncionarioR', '=', $ID_Funcionario)
                                ->where('ID_Documento', '=', $this->ID_Documento_T)
                                ->where('FechaE', '=', NULL)->get()->last();

                                if(!empty($UltimoActivoQueEnvia->ID_IntDocFunc)){
                                    $DocFunc =DocFunc::find($UltimoActivoQueEnvia->ID_IntDocFunc);
                                    $DocFunc->FechaE         = date("Y/m/d");
                                    $DocFunc->ActivoEnvio      = 1;
                                    $DocFunc->Estado         = 1;
                                    $DocFunc->save();
                                    
                                }

                                                if($this->OpcionFirma==1){
                                                    
                                                    $DestinoDocumento =  DB::table('DestinoDocumento') 
                                                    ->select('ID_DestinoDocumento')
                                                    ->where('ID_FSube', '=',$ID_Funcionario)->get();
        
                                                    foreach ($DestinoDocumento as $Documentos) { 
        
                                        
                                                        $DocumentoFirma                  = new DocumentoFirma;
                                                        $DocumentoFirma->ID_Funcionario  = $this->Destinatarios;
                                                        $DocumentoFirma->ID_Documento    =  $Documentos->ID_DestinoDocumento;  
                                                        $DocumentoFirma->Firmado         = 0;  
                                                        $DocumentoFirma->save(); 
                                                    }
        
        
                                        

                                                }

                                           
                                            


                                        
                                        
                                                    



                                
                                        
                                                

                                                $this->Destinatarios="";
                                                $this->ObservacionEAbajo="";

                                         
                                                $this->resetPage();
                                                $this->resetErrorBag(); 
                                                

                                            

                                    

                    }     
                    else{
                        session()->flash('messageEnviado', 'Para aceptar una solicitud, primero debe firmar sus archivos.');
                    }
                 
                  
                  
                  }
                 
                  public function Visto($ID_Documento_T)
                  {

                    $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
                
                    $Datos =  DB::table('DocFunc') 
                        ->leftjoin('Documento', 'DocFunc.ID_Documento', '=', 'Documento.ID_Documento_T')
                        ->leftjoin('Funcionarios', 'DocFunc.ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
                        ->select('ID_IntDocFunc')
                        ->where('ID_Documento', '=',$ID_Documento_T)
                        ->where('ID_Funcionario', '=',$ID_Funcionario)->get();
  
                          foreach ($Datos as $user){
                            $ID_IntDocFunc  = $user->ID_IntDocFunc;
                          } 
  
  
                
                         
                   
                    $DocFunc =DocFunc::find($ID_IntDocFunc);
                    $DocFunc->Visto        = 1;
                    $DocFunc->Fecha_V            = date("Y/m/d");
                    $DocFunc->save();

                   }


      
 
   
                  public $M_Detalles;
                  public $Id_Multas; 
                  public $Datos; 
                  public $Testigo;
                  
            

                    
                  
                  
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
                      $this->Detalles='1';
                    
                      $DocFunc =DocFunc::find($this->IDAnular);
                      $DocFunc->delete();
                    
                      
                      session()->flash('message2', 'Envio anulado a '.  $this->NombresAnular.' '.$this->ApellidosAnular);
                    
                    }
                        





                
              


               
                  
                    

                  

              public $Funcionarios;
              public $MostrarOpciones;
              public $TipoFirma;
  


    
    public $Opciones=0;
    public $RespuestaOpciones=0;
    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {

      if($this->Opciones==0){
        $this->RespuestaOpciones=0;
      }
      elseif($this->Opciones==1){
        $this->RespuestaOpciones=1;
      }
      else{ 
        $this->RespuestaOpciones=3;
      }
    
      

 
  
 

        $this->Funcionarios =  DB::table('Funcionarios')->get();
 

        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
 

       

        
        $this->TipoFirma =  DB::table('Funcionarios')
        ->select('TipoFirma')  
        ->where('ID_Funcionario_T', '=', $ID_Funcionario)->get();
    
 
        return view('livewire.documentos.documentos-recibidos',[

			'posts' =>  DB::table('DocFunc') 
            ->leftjoin('Documento', 'DocFunc.ID_Documento', '=', 'Documento.ID_Documento_T') 
            ->leftjoin('Funcionarios', 'Documento.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
            ->leftjoin('TipoDocumento', 'Documento.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->where('Estado', '=', 0) 
            ->where('Estado_T', '=', 1)  
            ->where(function($query) {
                $query->orwhere('Folio', 'like', "%{$this->search}%")
                        ->orwhere('Titulo_T', 'like', "%{$this->search}%")
                        ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                        ->orwhere('Observacion_T', 'like', "%{$this->search}%");
            })         
            ->where('DocFunc.ID_FuncionarioR', '=', $ID_Funcionario)     
            ->where('DocFunc.ActivoEnvio', '=', 1)    
            ->paginate($this->perPage), 
          

  
 
 
            'FuncionariosAsig' =>  DB::table('DocFunc') 
            ->leftjoin('Funcionarios AS EMIS', 'DocFunc.ID_FuncionarioE', '=', 'EMIS.ID_Funcionario_T')
            ->leftjoin('Funcionarios AS RECEP', 'DocFunc.ID_FuncionarioR', '=', 'RECEP.ID_Funcionario_T') 
            ->select('ID_IntDocFunc','ID_FuncionarioE','EMIS.Nombres AS NombreEmis','EMIS.Apellidos AS ApellidoEmis','Mensaje_E','RECEP.Nombres AS NombreRecp','RECEP.Apellidos AS ApellidoRecp','Mensaje_R','FechaR','FechaE','Estado','Visto','Fecha_V') 
            ->where('ID_Documento', '=',$this->ID_Documento_T)   
            ->paginate(4),
        
          
          'MostrarDocumentos' =>  DB::table('DestinoDocumento') 
          ->leftjoin('DocumentoFirma', 'DestinoDocumento.ID_DestinoDocumento', '=', 'DocumentoFirma.ID_Documento')
          ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
          ->select('ID_FSube','NombreDocumento','ID_DestinoDocumento','ID_DocumentoFirma','ID_Documento','FechaFirma','Firmado','Nombres','Apellidos')
          ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)
          ->where('ID_Funcionario', '=',$ID_Funcionario)->paginate(4),


          
          'DocumentosSubidos' =>  DB::table('DestinoDocumento')
          ->where('ID_FSube', '=',$ID_Funcionario)->get(),
          'DocumentosSubidosTotal' =>  DB::table('DestinoDocumento') 
          ->leftjoin('Funcionarios', 'DestinoDocumento.ID_FSube', '=', 'Funcionarios.ID_Funcionario_T')
          ->select('Nombres','Apellidos','NombreDocumento','ID_DestinoDocumento')
          ->where('DOC_ID_Documento', '=',$this->ID_Documento_T)->paginate(4),
        ]);
    }
}
 