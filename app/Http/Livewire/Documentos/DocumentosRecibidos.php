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

class DocumentosRecibidos extends Component
{
  
                use WithPagination;  
                public $Detalles=0;

                //Boton datatable firmar documento  
                public $ID_Documento_T;
                public function FirmarDocumento($ID_Documento_T){
                  $this->ID_Documento_T=$ID_Documento_T;
                  $this->Detalles='1'; 
                } 

                //Boton datatable Enviar Documento  
                public function Opciones($ID_Documento_T)
                {
                  $this->Detalles='2';
                  $this->ID_Documento_T=$ID_Documento_T;

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

                public function VolverPrincipal(){
                  $this->Detalles='0';
                  $this->resetPage();
                  $this->resetErrorBag();
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
                  ->leftjoin('Documento', 'DocFunc.ID_Documento', '=', 'Documento.ID_Documento_T')
                  ->leftjoin('DocumentoFirma', 'Documento.ID_Documento_T', '=', 'DocumentoFirma.ID_Documento')
                  ->select('ID_IntDocFunc','Firmado')
                  ->where('DocFunc.ID_Funcionario', '=',$ID_Funcionario)
                  ->where('DocFunc.ID_Documento', '=',$this->ID_Documento_T)
                  ->where('FechaE', '=',NULL)->get();
           
          
                    foreach ($Datos as $user){
                      $ID_IntDocFunc  = $user->ID_IntDocFunc;
                   
                       
                    } 
 
                    
                  
                       
                      $Buscar_ID_IntDocFunc  =  DB::table('Documento') 
                      ->leftjoin('DocFunc', 'Documento.ID_Documento_T', '=', 'DocFunc.ID_Documento')
                      ->where('ID_Documento', '=',$this->ID_Documento_T)
                      ->where('FechaE', '=',NULL)
                      ->where('ID_Funcionario', '=',$ID_Funcionario)->get();
                      
                      
                      foreach ($Buscar_ID_IntDocFunc as $user){
                          $ID_IntDocFunc  = $user->ID_IntDocFunc;
                
                        }
                 
                        
                        $Documento =Documento::find($this->ID_Documento_T);
                        $Documento->Estado_T            = 2;
                        $Documento->save(); 
                        

                    $DocFunc =DocFunc::find($ID_IntDocFunc);
                    $DocFunc->FechaE         = date("Y/m/d");
                    $DocFunc->Estado         = 3;
            
                    $DocFunc->save();
                    
                 
                    $this->Detalles='0';
                    $this->resetPage();
                    $this->resetErrorBag();

                  }
                       
                 
                
                
                
                















                //Finalizar Documento 
               
                 
                public function FinalizarDocumento(){ 
                 

                  $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;
                 
                  $Datos =  DB::table('DocFunc') 
                  ->leftjoin('Documento', 'DocFunc.ID_Documento', '=', 'Documento.ID_Documento_T')
                  ->leftjoin('DocumentoFirma', 'Documento.ID_Documento_T', '=', 'DocumentoFirma.ID_Documento')
                  ->select('ID_IntDocFunc','Firmado')
                  ->where('DocFunc.ID_Funcionario', '=',$ID_Funcionario)
                  ->where('DocFunc.ID_Documento', '=',$this->ID_Documento_T)
                  ->where('FechaE', '=',NULL)->get();
           
          
                    foreach ($Datos as $user){
                      $ID_IntDocFunc  = $user->ID_IntDocFunc;
                      $Firmado   = $user->Firmado;
                   
                       
                    } 

                    
                    $VerFirma =  DB::table('Documento') 
                    ->leftjoin('DocumentoFirma', 'Documento.ID_Documento_T', '=', 'DocumentoFirma.ID_Documento')
                    ->select('FechaFirma','Firmado')
                    ->where('DocumentoFirma.ID_Funcionario', '=',$ID_Funcionario)
                    ->where('DocumentoFirma.ID_Documento', '=',$this->ID_Documento_T)
                    ->where('FechaFirma', '!=',NULL)->first();
             
            
                    
          if(!empty($VerFirma->Firmado)){     
                       
                      $Buscar_ID_IntDocFunc  =  DB::table('Documento') 
                      ->leftjoin('DocFunc', 'Documento.ID_Documento_T', '=', 'DocFunc.ID_Documento')
                      ->where('ID_Documento', '=',$this->ID_Documento_T)
                      ->where('FechaE', '=',NULL)
                      ->where('ID_Funcionario', '=',$ID_Funcionario)->get();
                      
                      
                      foreach ($Buscar_ID_IntDocFunc as $user){
                          $ID_IntDocFunc  = $user->ID_IntDocFunc;
                
                        }
                 
                        
 
                          $CreDocFunc                     = new CreDocFunc;
                          $CreDocFunc->Id_DocFunc_Cre      =  $ID_IntDocFunc;
                          $CreDocFunc->ID_Funcionario_Cre  = $ID_Funcionario;
         
                          $CreDocFunc->save();
     

                    $Documento =Documento::find($this->ID_Documento_T);
                    $Documento->Estado_T            = 1;
                    $Documento->save(); 

                    $DocFunc =DocFunc::find($ID_IntDocFunc);
                    $DocFunc->FechaE         = date("Y/m/d");
                    $DocFunc->Estado         = 2;
                    $DocFunc->save();
                 
                    $this->Detalles='0';
                    $this->resetPage();
                    $this->resetErrorBag();

                  }
                       
                  else{
                   session()->flash('messageFinalizado', 'Solo los documentos firmados pueden ser finalizados.');
                  }
                
                }
                
                
                
                
                
                
                
                
                
                
             
                
                public $Destinatarios;
                public $ObservacionEAbajo; 

                protected $rules = ['Destinatarios' => 'required'];
                protected $messages = ['Destinatarios.required' =>'El campo Enviar es obligatorio.'];
                
                public function EnviarDocumento() 
                {
                   
                  $this->validate(); 

                  // Varriable general al apretar opciones ID_Documento_T

                  $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

                      $Datos =  DB::table('DocFunc') 
                      ->leftjoin('Documento', 'DocFunc.ID_Documento', '=', 'Documento.ID_Documento_T')
                      ->leftjoin('DocumentoFirma', 'Documento.ID_Documento_T', '=', 'DocumentoFirma.ID_Documento')
                      ->select('ID_IntDocFunc','Firmado')
                      ->where('DocFunc.ID_Funcionario', '=',$ID_Funcionario)
                      ->where('DocFunc.ID_Documento', '=',$this->ID_Documento_T)
                      ->where('FechaE', '=',NULL)->get();
               
              
                        foreach ($Datos as $user){
                          $ID_IntDocFunc  = $user->ID_IntDocFunc;
                          $Firmado   = $user->Firmado;
                       
                           
                        } 

                        


                         $VerFirma =  DB::table('Documento') 
                        ->leftjoin('DocumentoFirma', 'Documento.ID_Documento_T', '=', 'DocumentoFirma.ID_Documento')
                        ->select('FechaFirma','Firmado')
                        ->where('DocumentoFirma.ID_Funcionario', '=',$ID_Funcionario)
                        ->where('DocumentoFirma.ID_Documento', '=',$this->ID_Documento_T)
                        ->where('FechaFirma', '!=',NULL)->first();
                 
                
                        
                        if(!empty($VerFirma->Firmado)){     



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
                $DocFunc->Mensaje_Cre      =$this->ObservacionEAbajo;
                $DocFunc->save();




                $DocFunc =DocFunc::find($ID_IntDocFunc);
                $DocFunc->FechaE         = date("Y/m/d");
                $DocFunc->Estado         = 1;
                $DocFunc->save();


 







                        $DocFunc3                    = new CreDocFunc;
                        $DocFunc3->Id_DocFunc_Cre    = $DocFunc->ID_IntDocFunc;
                        $DocFunc3->ID_Funcionario_Cre= $ID_Funcionario;
                        $DocFunc3->Mensaje_Cre       = $this->ObservacionEAbajo;
                        $DocFunc3->save();
                


            
              
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



    
             
                    

                    $this->Destinatarios="";
                    $this->ObservacionEAbajo="";
                    

                

           

              }
                       
                 else{
                  session()->flash('messageEnviado', 'Solo los documentos firmados pueden ser enviados.');
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


      
 
                  public $search; 
                  public $perPage = '5';
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

      if($this->Opciones==1){
        $this->RespuestaOpciones=1;
      }
      elseif($this->Opciones==2){
        $this->RespuestaOpciones=2;
      }
      elseif($this->Opciones==3){ 
        $this->RespuestaOpciones=3;
      }
      elseif($this->Opciones==4){ 
        $this->RespuestaOpciones=4;
      }
      

 
  
 

        $this->Funcionarios =  DB::table('Funcionarios')->get();


        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $this->TipoFirma =  DB::table('Funcionarios')
        ->select('TipoFirma') 
        ->where('ID_Funcionario_T', '=', $ID_Funcionario)->get();

        return view('livewire.documentos.documentos-recibidos',[

			  'posts' =>  DB::table('DocFunc') 
          ->leftjoin('Documento', 'DocFunc.ID_Documento', '=', 'Documento.ID_Documento_T') 
          ->leftjoin('TipoDocumento', 'Documento.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
          ->leftjoin('DocumentoFirma', 'Documento.ID_Documento_T', '=', 'DocumentoFirma.ID_Documento')
          ->where('Estado', '=', 0) 
          ->where('Estado_T', '=', 0)  
          ->where(function($query) {
                $query->orwhere('Titulo_T', 'like', "%{$this->search}%")
                      ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                      ->orwhere('Observacion_T', 'like', "%{$this->search}%");
          })         
          ->where('DocFunc.ID_Funcionario', '=', $ID_Funcionario)   
          ->where('DocumentoFirma.ID_Funcionario', '=', $ID_Funcionario)     
          ->where('DocFunc.ActivoEnvio', '=', 1)    
          ->paginate($this->perPage), 
          
        'FuncionariosAsig' =>  DB::table('DocFunc') 
          ->leftjoin('Funcionarios', 'DocFunc.ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
          ->where('ID_Documento', '=',$this->ID_Documento_T) 
          ->paginate(4)
        ]);
    }
}
 