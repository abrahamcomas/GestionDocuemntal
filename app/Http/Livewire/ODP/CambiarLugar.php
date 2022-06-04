<?php

namespace App\Http\Livewire\ODP;

use Livewire\Component;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use App\Models\FuncionarioModels;
use App\Models\LugarDeTrabajo;

class CambiarLugar extends Component
{
    public $BuscarOficinaPartes; 
    public $NombreOficinaParte; 
    public $OficinaPartes;
    public $ID_DepDir; 
    public function OficinaPartesSeleccionada($ID_DepDir){

        $NombreOficinaParte =  DB::table('DepDirecciones')
        ->select('ID_DepDir','Nombre_DepDir')
        ->where('ID_DepDir', '=', $ID_DepDir)->first();

        $this->ID_DepDir = $ID_DepDir;
        $this->NombreOficinaParte=$NombreOficinaParte->Nombre_DepDir;

 
        $this->BuscarOficinaPartes = "";
 
    }
    public function Ayuda(){ 
        $this->Ayuda = 1;
    }
     
    public $DestinoFuncionario;

    protected $rules = ['DestinoFuncionario' => 'required',
                        'ID_DepDir' => 'required']; 

	protected $messages = [ 'DestinoFuncionario.required' =>'El campo "SELECCIONAR FUNCIONARIO" es obligatorio.',
                            'ID_DepDir.required' =>'El campo "Buscar departamento o direcció" es obligatorio.'];

    public function Ingresar()
    {   
        $this->validate();
        
        $Lugares =  DB::table('DepDirecciones') 
        ->where('EstadoDirDep', '=', 1)  
        ->get();

        $LugarDeTrabajo=LugarDeTrabajo::where('ID_Funcionario_LDT', $this->DestinoFuncionario)->first();
        $LugarDeTrabajo->ID_DepDirecciones_LDT = $this->ID_DepDir;
        $LugarDeTrabajo->Estado_LDT = 0;
        $LugarDeTrabajo->save(); 

        $FuncionarioModels=FuncionarioModels::find($this->DestinoFuncionario); 
        $FuncionarioModels->Activo = 0; 
        $FuncionarioModels->save(); 

        DB::table('sessions')->where('user_id', $this->DestinoFuncionario)->delete(); 

        $LugarDeTrabajo =  DB::table('LugarDeTrabajo')
        ->select('ID_DepDirecciones_LDT')  
        ->where('ID_Funcionario_LDT', '=', $this->DestinoFuncionario)->first();

        $OficinaPartes =  DB::table('OficinaPartes')
        ->select('Id_OP')  
        ->where('ID_OP_LDT', '=', $LugarDeTrabajo->ID_DepDirecciones_LDT)->first();
 
        $InterPortaFuncionario =  DB::table('InterPortaFuncionario')
        ->select('IPF_ID')  
        ->where('Estado', '=', 11)
        ->where('IPF_ID_Funcionario', '=', $this->DestinoFuncionario)->get();

        if(!empty($InterPortaFuncionario)){
            
            foreach ($InterPortaFuncionario as $InterPortaF) {  

                $InterPortaFuncionario=InterPortaFuncionario::find($InterPortaF->IPF_ID);
                $InterPortaFuncionario->IPF_Id_OP = $InterPortaFuncionario->IPF_ID;
                $InterPortaFuncionario->save();
            }

        }
    
     
        session()->flash('message', 'Cambiado Correctamente');  
    } 

    public $Pagina;
    public function Volver()
    {  
        $this->Pagina=0;
    } 
 
    public $TipoDocumento; 
    public $Existe; 
    public $MostrarPagina=1;
    public $ListaFuncionariosOP; 
    public function render()
    {

        $this->TipoDocumento =  DB::table('TipoDocumento')
        ->where('EstadoTipoDocumento','=', 1)
        ->get();

        $Funcionario  =  Auth::user()->ID_Funcionario_T; 

        $VerDisponibilidad =  DB::table('OficinaPartes')
        ->where('id_Funcionario_OP', '=',$Funcionario) 
        ->first();

        if($VerDisponibilidad->Original!=1){
            $this->MostrarPagina = 0;
        }

 
        $OficinaPartes =  DB::table('OficinaPartes')
        ->leftjoin('DepDirecciones', 'OficinaPartes.ID_OP_LDT', '=', 'DepDirecciones.ID_DepDir')
        ->select('ID_DepDir','Nombre_DepDir')
        ->where('Original', '=', 1)
        ->where('id_Funcionario_OP', '=', $Funcionario)->get();
        
        $Numero = count($OficinaPartes);

        if($Numero!=0){

            foreach ($OficinaPartes as $user){
                $this->NombreDireccion = $user->Nombre_DepDir;
                $ID_DepDir = $user->ID_DepDir;
            } 
 
               
            $this->ListaFuncionariosOP =  DB::table('Funcionarios')
            ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
            ->where('ID_Funcionario_T', '!=', $Funcionario)
            ->where('ID_DepDirecciones_LDT', '=', $ID_DepDir)->get();
            $this->mostrar=1;

        } 
 

 
        $DatosFirma =  DB::table('Funcionarios')
        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
        ->select('Rut','Nombres','Apellidos','Nombre_DepDir','Cargo','ID_DepDir')->where('ID_Funcionario_T', '=',$Funcionario)->first();

  
        $this->Rut = $DatosFirma->Rut;
        $this->Nombres = $DatosFirma->Nombres;
        $this->Apellidos = $DatosFirma->Apellidos;   
        $this->Oficina = $DatosFirma->Nombre_DepDir;
        $this->Cargo = $DatosFirma->Cargo;

        $ID_DepDir = $DatosFirma->ID_DepDir;

        $Lista =  DB::table('ImagenFirma') 
        ->where('id_Funcionario_T', '=',$Funcionario)
        ->get(); 

        $this->Existe=count($Lista); 


        $this->OficinaPartes =  DB::table('DepDirecciones')
        ->where('EstadoDirDep', '=', 1)    
        ->where('Nombre_DepDir', 'like', "%{$this->BuscarOficinaPartes}%")->take(3)->get();



        return view('livewire.o-d-p.cambiar-lugar',[
            'DatosOficinaPartes' =>  DB::table('OficinaPartes') 
            ->leftjoin('Funcionarios', 'OficinaPartes.id_Funcionario_OP', '=', 'Funcionarios.ID_Funcionario_T') 
            ->select("Nombres","Apellidos")->where('ID_OP_LDT', '=',$ID_DepDir)
            ->first(),
            'plantillas' =>  DB::table('plantillas')->get(), 
      ]);
    }
}
  