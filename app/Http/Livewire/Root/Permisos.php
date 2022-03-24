<?php

namespace App\Http\Livewire\Root;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;  
use App\Models\Roles;
use Illuminate\Support\Facades\Auth; 

 
class Permisos extends Component
{
    use WithPagination;  
    public $search; 
    public $perPage = 5;
    public $Detalles=0; 
    public $ID_Funcionario_T; 
    public $Nombres;
    public $Apellidos;

    public function clear()
    { 
      $this->search='';
      $this->perPage='5'; 
    } 
 
    public function Volver()
    {
      $this->Detalles=0;
    }
    public function Administrar($ID_Documento_T){ 

        $this->ID_Funcionario_T=$ID_Documento_T;
        $this->Detalles=1;

        $Datos =  DB::table('Funcionarios')->where('ID_Funcionario_T', '=',$ID_Documento_T)->first();

        $this->Nombres   = $Datos->Nombres;
        $this->Apellidos   = $Datos->Apellidos;
        
    } 

    public function Agregar($id_Menu) 
    { 

        $Datos =  DB::table('Roles')->where('Navegador', '=',$id_Menu)->get();


        $Numero = count($Datos);

       
        if($Numero==0){

            $Roles                       = new Roles;
            $Roles->id_Funcionario_Roles = $this->ID_Funcionario_T;
            $Roles->Navegador            = $id_Menu;
            $Roles->save();
    

        }
   

       
        $this->Detalles=1;              
    }  



    public function Eliminar($Id_Roles) 
    {
        
        $Roles =Roles::find($Id_Roles);
        $Roles->delete();

        $this->Detalles=1;             
    } 
 
    protected $paginationTheme = 'bootstrap'; 
    public function render()
    {
        return view('livewire.root.permisos',[
            'Lista' =>  DB::table('Funcionarios') 
                ->leftjoin('ImagenFirma', 'Funcionarios.ID_Funcionario_T', '=', 'ImagenFirma.id_Funcionario_T') 
                ->where(function($query) { 
                    $query->orwhere('Rut', 'like', "%{$this->search}%");
              }) 
            ->paginate(10), 
            'Roles' =>  DB::table('Roles')
                ->leftjoin('Menu', 'Roles.Navegador', '=', 'Menu.id_Menu') 
                ->where('id_Funcionario_Roles', '=',$this->ID_Funcionario_T)->paginate(10),
            'Menu' =>  DB::table('Menu')->where('Visto', '=',0)->paginate(10) 
        ]);
    }
}
