<?php

namespace App\Http\Livewire\ODP;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\ImagenFirma;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; 
use App\Models\OficinaPartes;
use App\Models\FuncionarioModels;

class AdministrarODP extends Component
{
       
       use WithPagination;  
       public $search;  
       public $perPage = 10; 
       public $Detalles=0; 

       public function clear()
       {
         $this->search=''; 
         $this->perPage='5';
       }
    
       public function Volver()
       {
           $this->Detalles=0;                    
      
       } 
   
       public $Seleccionado_ID;  

       public $Funcionario_R;  
       public $ODP_R;  

       public $ResultadoJefe; 
       public $ResultadoSecretaria; 
       public $MismaOPD;
       public $ListaODP;
    public function Administrar($ID_Funcionario){

        $this->Seleccionado_ID=$ID_Funcionario;

        $FuncionarioReceptor =  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
            ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
            ->leftjoin('OficinaPartes', 'DepDirecciones.ID_DepDir', '=', 'OficinaPartes.ID_OP_LDT') 
            ->select('ID_Funcionario_T','Rut','Nombres','Apellidos','Nombre_DepDir','Id_OP','id_Funcionario_OP','ID_Jefatura')
            ->where('ID_Funcionario_T', '=',$ID_Funcionario) 
            ->where('Original', '=',1) 
            ->first();

        if(!empty($FuncionarioReceptor)){

            if($FuncionarioReceptor->ID_Jefatura==$ID_Funcionario){
                
                $this->ResultadoJefe =  1;


            }else{
                $this->ResultadoJefe =  0;


            }

            if($FuncionarioReceptor->id_Funcionario_OP==$ID_Funcionario){
                
                $this->ResultadoSecretaria =  1;

            }else{ 
                $this->ResultadoSecretaria =  0;


            }

            $this->ListaODP =  DB::table('OficinaPartes')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
            ->select('Nombre_DepDir')
            ->where('id_Funcionario_OP', '=',$ID_Funcionario)
            ->where('ActivoODP', '!=',3)
            ->get();


        }

            

            $this->Funcionario_R = $FuncionarioReceptor->Nombres.' '.$FuncionarioReceptor->Apellidos;
            $this->OPD_R =  $FuncionarioReceptor->Nombre_DepDir;

            $ID_F_ODP_Origen  =  Auth::user()->ID_Funcionario_T; 

            $ODP_Origen =  DB::table('OficinaPartes')
                ->where('id_Funcionario_OP', '=',$ID_F_ODP_Origen) 
                ->where('Original', '=',1) 
                ->first();

            $ODP_Receptor =  DB::table('OficinaPartes')
                ->where('ID_OP_LDT', '=',$ODP_Origen->ID_OP_LDT) 
                ->where('ActivoODP', '!=',3)
                ->where('id_Funcionario_OP', '=',$ID_Funcionario)
                ->first();

            if(!empty($ODP_Receptor->Id_OP)){
                
                if($ODP_Origen->ID_OP_LDT==$ODP_Receptor->ID_OP_LDT){
                
                    $this->MismaOPD =  1;
    
                }else{
                    $this->MismaOPD =  0;
    
                }

            } else{

                $this->MismaOPD =  0;

            }      
            

            $this->Detalles=1;              
    }   

    
      
    public function Desabilitar(){ 
   

        $ID_F_ODP_Origen  =  Auth::user()->ID_Funcionario_T; 

        $ODP_Origen =  DB::table('OficinaPartes')
            ->where('id_Funcionario_OP', '=',$ID_F_ODP_Origen) 
            ->where('Original', '=',1) 
            ->first();
   
        $OficinaPartes                    = OficinaPartes::where('ID_OP_LDT',$ODP_Origen->ID_OP_LDT)->where('id_Funcionario_OP',$this->Seleccionado_ID)->first();
        $OficinaPartes->ActivoODP            = 3;
        $OficinaPartes->Original          = 0;
        $OficinaPartes->save();


        $ActivoSecretaria             = FuncionarioModels::find($this->Seleccionado_ID);
        $ActivoSecretaria->Secretaria  = 0;
        $ActivoSecretaria->save();
        
        $this->Detalles=0;    
          
    }

    public function Agregar(){ 

        $ID_F_ODP_Origen  =  Auth::user()->ID_Funcionario_T; 

        $ODP_Origen =  DB::table('OficinaPartes')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
            ->select('ID_DepDir','Id_OP','ID_OP_LDT','ID_Jefatura')
            ->where('id_Funcionario_OP', '=',$ID_F_ODP_Origen) 
            ->first();


        $ODP_SiExiste =  DB::table('OficinaPartes')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
            ->select('ID_DepDir','Id_OP','ID_Jefatura')
            ->where('ID_OP_LDT', '=', $ODP_Origen->ID_OP_LDT)
            ->where('id_Funcionario_OP', '=', $this->Seleccionado_ID) 
            ->where('ActivoODP', '=', 3)
            ->where('Original', '=', 0)
            ->first();


        $VerEstado =  DB::table('Funcionarios')
            ->select('Secretaria')
            ->where('ID_Funcionario_T', '=',$this->Seleccionado_ID) 
            ->first();
    
        if($VerEstado->Secretaria==1){

            if(!empty($ODP_SiExiste)){
                
                $OficinaPartes                    = OficinaPartes::find($ODP_SiExiste->Id_OP);
                $OficinaPartes->ActivoODP         = 1;
                $OficinaPartes->Original          = 0;
                $OficinaPartes->save();


            }else{

                $OficinaPartes                    = new OficinaPartes;
                $OficinaPartes->ID_OP_LDT         = $ODP_Origen->ID_DepDir;
                $OficinaPartes->id_Funcionario_OP = $this->Seleccionado_ID;
                $OficinaPartes->ID_Jefatura       = $ODP_Origen->ID_Jefatura;
                $OficinaPartes->ActivoODP         = 1;
                $OficinaPartes->Original          = 0;
                $OficinaPartes->save();

            }

        }
        else{

            $ActivoSecretaria             = FuncionarioModels::find($this->Seleccionado_ID);
            $ActivoSecretaria->Secretaria  = 1;
            $ActivoSecretaria->save();
            
            if(!empty($ODP_SiExiste)){
                
                $OficinaPartes                    = OficinaPartes::find($ODP_SiExiste->Id_OP);
                $OficinaPartes->ActivoODP         = 2;
                $OficinaPartes->Original          = 0;
                $OficinaPartes->save();


            }else{

                $OficinaPartes                    = new OficinaPartes;
                $OficinaPartes->ID_OP_LDT         = $ODP_Origen->ID_DepDir;
                $OficinaPartes->id_Funcionario_OP = $this->Seleccionado_ID;
                $OficinaPartes->ID_Jefatura       = $ODP_Origen->ID_Jefatura;
                $OficinaPartes->ActivoODP         = 2;
                $OficinaPartes->Original          = 0;
                $OficinaPartes->save();

            }
        
        
        
        
        }

    

        $this->Detalles=0;

    }

   
    public $FuncionariosApoyo;
    public $MostrarPagina=1;
    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
        $ID_Funcionario_T  =  Auth::user()->ID_Funcionario_T; 


        $VerDisponibilidad =  DB::table('OficinaPartes')
            ->where('id_Funcionario_OP', '=',$ID_Funcionario_T) 
            ->first();
 
            if($VerDisponibilidad->Original!=1){
                $this->MostrarPagina = 0;
            }



        $ODP_Origen =  DB::table('OficinaPartes')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
            ->select('ID_OP_LDT')
            ->where('id_Funcionario_OP', '=',$ID_Funcionario_T) 
            ->first();

        $this->FuncionariosApoyo =  DB::table('OficinaPartes')
        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
        ->select('ID_Funcionario_T','Rut','Nombres','Apellidos','Nombre_DepDir','Id_OP','id_Funcionario_OP','ID_Jefatura')
        ->where('ID_OP_LDT', '=',$ODP_Origen->ID_OP_LDT) 
        ->where('ActivoODP', '!=',3) 
        ->where('Original', '!=',1) 
        ->get();

        return view('livewire.o-d-p.administrar-o-d-p',[ 
            'Lista' =>  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
            ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
            ->select('ID_Funcionario_T','Rut','Nombres','Apellidos','Nombre_DepDir')
                ->where(function($query) { 
                    $query->orwhere('Rut', 'like', "%{$this->search}%")
                    ->orwhere('Nombres', 'like', "%{$this->search}%")
                    ->orwhere('Apellidos', 'like', "%{$this->search}%");
              }) 
            ->where('ID_Funcionario_T', '!=',$ID_Funcionario_T) 
            ->paginate($this->perPage), 
      ]);
    }
}
