<?php 

namespace App\Http\Livewire\Registro;

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use App\Models\FuncionarioModels;
use App\Models\PlantaContrata;
use App\Models\Codigo;
use App\Models\Cementerio;
use App\Models\Roles;
use App\Models\LugarDeTrabajo;
use Illuminate\Support\Facades\Hash; 


class Registrarse extends Component
{

    public $BuscarOficinaPartes; 
    public $NombreOficinaParte; 
    public $OficinaPartes;
    public $Estado=1;
    public $Resultado;


    public $Id_OP_Receptor;
    
    public $ID_DepDir; 
    public function OficinaPartesSeleccionada($ID_DepDir){

        $NombreOficinaParte =  DB::table('DepDirecciones')
        ->select('ID_DepDir','Nombre_DepDir')
        ->where('ID_DepDir', '=', $ID_DepDir)->first();

        $this->ID_DepDir = $ID_DepDir;
        $this->NombreOficinaParte=$NombreOficinaParte->Nombre_DepDir;

 
        $this->BuscarOficinaPartes = "";
 
    }

    public $Rut;
    public $Nombres;
    public $Apellidos;
    public $Contrasenia;
    public $Confirmar_Contrasenia;
    public $Email;
    public $Telefono;
    public $Cargo;
    public $Activo = 0;
    public $Existe = 0;

    protected $rules = [
        'Rut' => 'required', 
        'Nombres' => 'required', 
        'Apellidos' => 'required', 
        'Contrasenia' => 'required|min:6',
        'Confirmar_Contrasenia' => 'required:Contrasenia|same:Contrasenia|min:6|different:password',
        'Email' => 'required',
        'Telefono' => 'required',
        'Cargo' => 'required',
        'ID_DepDir' => 'required',
    ];

    protected $messages = [
        'Rut.required' =>'El campo "Rut" es obligatorio.',
        'Nombres.required' =>'El campo "Nombres" es obligatorio.',
        'Apellidos.required' =>'El campo "Apellidos" es obligatorio.',
        'Contrasenia.required' =>'El campo "Contraseña" es obligatorio.',
        'Confirmar_Contrasenia.required' =>'El campo "Confirmar Contraseña" es obligatorio.',
        'Email.required' =>'El campo "Email" es obligatorio.',
        'Telefono.required' =>'El campo "Teléfono" es obligatorio.',
        'Cargo.required'=>'El campo "Cargo" es obligatorio.',
        'ID_DepDir.required' =>'El campo "Departamento o dirección" es obligatorio.'
    ];
    public function Registro(){
         
        $this->validate(); 

        $Rut2 = $this->Rut;

         //Agrego 0 a rut menores a 10
         $LargoRun = strlen($this->Rut);
         if ($LargoRun < 10) {
            $Rut2=str_pad($Rut2, 10, "0", STR_PAD_LEFT);
         }

        $PlantaContrata=PlantaContrata::Select('Id_Funcionario')->whereActivo($this->Activo)->whereRut($Rut2)->get();
        $Existe=count($PlantaContrata);
    
        if($Existe==0){
    
            $PlantaContrata=Codigo::Select('Id_Funcionario')->whereActivo($this->Activo)->whereRut($Rut2)->get();
            $Existe=count($PlantaContrata);
    
        }
        if($Existe==0){
            $PlantaContrata=Cementerio::Select('Id_Funcionario')->whereActivo($this->Activo)->whereRut($Rut2)->get();
            $Existe=count($PlantaContrata);
    
        }
    
        $Funcionario=FuncionarioModels::select('Rut','Nombres')->whereRut($this->Rut)->first();
    
            if($Existe>=1 AND (!isset($Funcionario->Rut))) 
            {
                $ExisteEmail=DB::table('Funcionarios')->whereEmail($this->Email)->exists();
                if ($ExisteEmail==0) 
                {
                    
                        $user = new FuncionarioModels;
                        $user->Activo = 0;
                        $user->TipoFirma = 2;
                        $user->Root = 0;
                        $user->Subrogante = 0;
                        $user->Rut = $this->Rut; 
                        $user->Nombres = $this->Nombres;
                        $user->Apellidos = $this->Apellidos;
                        $user->Email = $this->Email;
                        $user->Telefono = $this->Telefono;
                        $user->Cargo = $this->Cargo;
                        $user->password = Hash::make($this->Contrasenia);
                        $user->save(); 
    
                        $LugarDeTrabajo = new LugarDeTrabajo;
                        $LugarDeTrabajo->ID_DepDirecciones_LDT   =  $this->ID_DepDir;
                        $LugarDeTrabajo->ID_Funcionario_LDT = $user->ID_Funcionario_T;
                        $LugarDeTrabajo->Estado_LDT = 0;
                        $LugarDeTrabajo->save();  

                        $Roles1 = new Roles;
                        $Roles1->id_Funcionario_Roles  = $user->ID_Funcionario_T;
                        $Roles1->Navegador  =  3;
                        $Roles1->save();  

                        $Roles2 = new Roles;
                        $Roles2->id_Funcionario_Roles  = $user->ID_Funcionario_T;
                        $Roles2->Navegador  =  4;
                        $Roles2->save(); 
                
                        $this->Resultado='Registro Realizado Correctamente, en espera de confirmación de ingreso por la oficina de partes';
                  
                }
                else
                {
                    $this->Resultado='Error, Email registrado anteriormenete, registro denegado.';
                }
            }
            elseif((isset($Funcionario->Rut)) AND (isset($Funcionario->Nombres)))
            {
                $this->Resultado='Error, Usuario registrado anteriormente.';
            }
            else
            {
                $this->Resultado='Error, Usuario sin autorización, registro denegado.';
            }
    
            $this->Estado=2;
    
        }
   
    public function render()
    {
       
        $this->OficinaPartes =  DB::table('DepDirecciones')
        ->where('EstadoDirDep', '=', 1)    
        ->where('Nombre_DepDir', 'like', "%{$this->BuscarOficinaPartes}%")->take(3)->get();

        return view('livewire.registro.registrarse');
    }
}
