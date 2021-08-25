<?php

namespace App\Http\Livewire\Documentos;

use Livewire\Component;
use Livewire\WithPagination; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth; 
use App\Models\DocFunc;
use App\Models\CreDocFunc;


class DocumentosFinalizados extends Component
{ 
    



   
    public $NombreMensaje;
    public $ApellidoMensaje;
    public $Mensaje;
    public function VerMensaje($ID_IntDocFunc){


        $Datos =  DB::table('DocFunc') 
        ->leftjoin('Funcionarios', 'DocFunc.ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
        ->leftjoin('CreDocFunc', 'DocFunc.ID_IntDocFunc', '=', 'CreDocFunc.Id_DocFunc_Cre')
        ->select('Mensaje_Cre','Nombres','Apellidos')
        ->where('ID_IntDocFunc', '=',$ID_IntDocFunc)->get();

          foreach ($Datos as $user){
            $this->NombreMensaje = $user->Nombres;
            $this->ApellidoMensaje = $user->Apellidos;
            $this->Mensaje = $user->Mensaje_Cre;
          } 

    }


    public function Detalles($ID_Documento_T)
    {
      $this->Detalles='3';

      $this->ID_Documento_T=$ID_Documento_T;

    


     }

  public $ID_Documento_T;


 
   public function clear()
    {
        $this->search='';
        $this->perPage='5';
        $this->AnioSelect=date('Y');
    }
 
 




    
    use WithPagination;  
    public $search; 
    public $perPage = '5';
    public $M_Detalles;
    public $Id_Multas; 
    public $Datos; 
  
    public $Detalles='0';
  
    

      
    

          



public function VolverPrincipal(){

      $this->Detalles='0';
      $this->resetPage();
      $this->resetErrorBag();
    }

    
 
      public $AnioSelect;
public $Funcionarios;
public $TipoFirma;

  protected $paginationTheme = 'bootstrap'; 
    public function render()
    {

        if ($this->AnioSelect=='') {
            $this->AnioSelect=date('Y'); 
          }

        $this->Funcionarios =  DB::table('Funcionarios')->get();

 
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

        $this->TipoFirma =  DB::table('Funcionarios')
        ->select('TipoFirma')
        ->where('ID_Funcionario_T', '=', $ID_Funcionario)->get();

        return view('livewire.documentos.documentos-finalizados',[

			  'posts' =>  DB::table('Documento') 
          ->leftjoin('TipoDocumento', 'Documento.Tipo_T', '=', 'TipoDocumento.ID_TipoDocumento_T')
          ->leftjoin('DocumentoFirma', 'Documento.ID_Documento_T', '=', 'DocumentoFirma.ID_Funcionario')
          ->where('Estado_T', '!=', 0)
          ->where('Anio','=', $this->AnioSelect)
          ->where(function($query) {
                $query->orwhere('Titulo_T', 'like', "%{$this->search}%")
                      ->orwhere('Tipo_T', 'like', "%{$this->search}%")
                      ->orwhere('Observacion_T', 'like', "%{$this->search}%"); 
          })  
          
          
          ->where('ID_Funcionario_Sol', '=', $ID_Funcionario)     
          ->paginate($this->perPage),
          'FuncionariosAsig' =>  DB::table('DocFunc') 
          ->leftjoin('Funcionarios', 'DocFunc.ID_Funcionario', '=', 'Funcionarios.ID_Funcionario_T')
          ->where('ID_Documento', '=',$this->ID_Documento_T) 
          ->paginate(4),
          'Anio' =>  DB::table('Documento')
          ->select('Anio')
          ->distinct('Anio')         
          ->get(), 
        ]);
    }  
}
