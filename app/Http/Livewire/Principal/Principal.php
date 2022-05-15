<?php

namespace App\Http\Livewire\Principal;

use Livewire\Component;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
 

class Principal extends Component
{
 
    public $PortafoliosDetenidos; 
    public $PortafoliosEnProceso;
    public $PortafoliosFinalizados;
    public $PortafoliosRecibidos; 
    public $PortafolioRecibidosVB;

    public $PortafolioExterno;
    public $PortafolioInterno; 
    public $PortafolioExternosVB; 
 
    public $PortafolioDirecto;

    public $Firmados;
    public function render()
    {
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

        $OficinaPartes =  DB::table('Funcionarios')
        ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.id_Funcionario_OP') 
        ->select('Id_OP','ID_OP_LDT')  
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first();

        $Id_OficinaParte =  DB::table('OficinaPartes')
        ->select('Id_OP')
        ->where('id_Funcionario_OP', '=', $ID_Funcionario)->first(); 


        $this->PortafoliosDetenidos = DB::table('Portafolio')
        ->select('ID_Documento_T') 
        ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
        ->where(function($query) {  
            $query->orwhere('Estado_T', '=', 0)
                    ->orwhere('Estado_T', '=', 11)
                    ->orwhere('Estado_T', '=', 22)
                    ->orwhere('Estado_T', '=', 33);
            })
        ->where('ID_Funcionario_Sol', '=', $ID_Funcionario)->count();

        $this->PortafoliosEnProceso =  DB::table('Portafolio') 
        ->select('ID_Documento_T')
        ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
        ->where(function($query) {
            $query->orwhere('Estado_T', '=', 1)
                    ->orwhere('Estado_T', '=', 2);  
        })
        ->where('ID_Funcionario_Sol', '=', $ID_Funcionario)     
        ->count();

        $this->PortafoliosFinalizados =  DB::table('Portafolio') 
        ->select('ID_Documento_T') 
        ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
        ->where(function($query) {
            $query->orwhere('Estado_T', '=', 3)
                    ->orwhere('Estado_T', '=', 4);  
            })   
        ->where('ID_Funcionario_Sol', '=', $ID_Funcionario)     
        ->count(); 

        $this->PortafoliosRecibidos =  DB::table('InterPortaFuncionario')
        ->leftjoin('Portafolio', 'InterPortaFuncionario.IPF_Portafolio', '=', 'Portafolio.ID_Documento_T')
        ->leftjoin('OficinaPartes', 'Portafolio.ID_OficinaP', '=', 'OficinaPartes.Id_OP')
        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
        ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
        ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
        ->select('ID_Funcionario_T')  
        ->where('Estado', '=', 0)             
        ->where('IPF_ID_Funcionario', '=', $ID_Funcionario)  
        ->count();

        $this->PortafolioRecibidosVB =  DB::table('Portafolio') 
        ->leftjoin('InterPortaFuncionarioVB', 'Portafolio.ID_Documento_T', '=', 'InterPortaFuncionarioVB.IPF_Portafolio')
        ->leftjoin('OficinaPartes', 'Portafolio.ID_OficinaP', '=', 'OficinaPartes.Id_OP')
        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
        ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
        ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T') 
        ->select('ID_Funcionario_T') 
        ->where(function($query) {
        $query->orwhere('Estado', '=', 0)
                ->orwhere('Estado', '=', 1);  
        })
        ->where('IPF_ID_Funcionario', '=', $ID_Funcionario)     
        ->where('Estado', '=', 0)     
        ->count();
 

        if(!empty($OficinaPartes->Id_OP)){

            $this->PortafolioExterno =  DB::table('Portafolio')  
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
            ->leftjoin('OficinaPartes', 'Portafolio.ID_OficinaP', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->leftjoin('DocFunc', 'Portafolio.ID_Documento_T', '=', 'DocFunc.ID_Documento') 
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->select('ID_Funcionario_T') 
            ->where('ActivoEnvio', '=', 1) 
            ->where('Estado', '=', 0) 
            ->where('Estado_T', '=', 2)   
            ->where('ID_OP_R', '=', $OficinaPartes->Id_OP)   
            ->where('DocFunc.ActivoEnvio', '=', 1)    
            ->count();

            $this->PortafolioExternosVB =  DB::table('Portafolio') 
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
            ->leftjoin('OficinaPartes', 'Portafolio.ID_OficinaP', '=', 'OficinaPartes.Id_OP')
            ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
            ->leftjoin('VistoBueno', 'Portafolio.ID_Documento_T', '=', 'VistoBueno.ID_Documento') 
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->select('ID_Funcionario_T') 
            ->where('Estado', '=', 0) 
            ->where('ID_OP_R', '=', $OficinaPartes->Id_OP)
            ->count();

        }

        if(!empty($OficinaPartes->Id_OP)){

            $this->PortafolioInterno =  DB::table('Portafolio')  
            ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
            ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
            ->select('ID_Funcionario_T') 
            ->where(function($query) {  
                $query->orwhere('Estado_T', '=', 1)
                    ->orwhere('Estado_T', '=', 2);
            }) 
            ->where('ID_OficinaP', '=', $Id_OficinaParte->Id_OP)     
            ->orderBy('FechaUrgencia_T', 'asc')    
            ->count(); 


        }

      

     

 

        $this->PortafolioDirecto =  DB::table('InterPortaFuncionario')
        ->leftjoin('Portafolio', 'InterPortaFuncionario.IPF_Portafolio', '=', 'Portafolio.ID_Documento_T')
        ->leftjoin('Funcionarios', 'Portafolio.ID_Funcionario_Sol', '=', 'Funcionarios.ID_Funcionario_T')
        ->leftjoin('TipoDocumento', 'Portafolio.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')   
        ->select('ID_Funcionario_T') 
        ->where('Estado_T', '=', 11)             
        ->where('IPF_ID_Funcionario', '=', $ID_Funcionario)
        ->orderBy('IPF_ID', 'asc')   
        ->count();


     

        return view('livewire.principal.principal');
    }
}
