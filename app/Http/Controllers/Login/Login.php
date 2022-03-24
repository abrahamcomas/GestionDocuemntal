<?php

namespace App\Http\Controllers\Login;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuncionarioModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{ 
    public function index(Request $request)
    {  

    	$rules = [
            'RUN' => 'required', 
            'password' => 'required|min:6',
        ];

        $messages = [
            'RUN.required' =>'El campo Rut es obligatorio.',
            'password.required' =>'El campo Contraseña es obligatorio.' 
        ];

        $this->validate($request, $rules, $messages);

        $RUN = $request->input('RUN'); 
        $password = $request->input('password');   
        $Activo0=0;

        $ExisteRUT=FuncionarioModels::Select('ID_Funcionario_T')->whereRut($RUN)->first();

        if (!empty($ExisteRUT->ID_Funcionario_T))
        {
            $ROOT =  DB::table('Funcionarios') 
            ->where('Rut', '=',$RUN)
            ->where('Root', '=',1)
            ->select('Rut')
            ->first(); 


            $JEFE =  DB::table('Funcionarios') 
            ->leftjoin('OficinaPartes', 'Funcionarios.ID_Funcionario_T', '=', 'OficinaPartes.ID_Jefatura') 
            ->where('Rut', '=',$RUN)
            ->where('ID_Jefatura', '!=',NULL)
            ->select('Rut')
            ->first();

            if (!empty($ROOT->Rut))
            { 

                if(Auth::attempt(['Rut' => $RUN, 'password' => $password], true))
                {

                    return view('Posts/Principal/PrincipalPosts');

                } 
                else
                { 
                return back()
                        ->withErrors(['Contraseña Incorrecta'])
                        ->withInput(request(['RUN']));
                }

            }
            elseif (!empty($JEFE->Rut))
            { 

                if(Auth::attempt(['Rut' => $RUN, 'password' => $password], true))
                { 

                    $ID_Funcionario  =  Auth::user()->ID_Funcionario_T;

                    $id_Funcionario_OP =  DB::table('OficinaPartes') 
                    ->select('id_Funcionario_OP')
                    ->where('ID_Jefatura', '=',$ID_Funcionario)
                    ->first(); 

                    if(!empty($id_Funcionario_OP->id_Funcionario_OP)){
                        return view('Posts/Principal/PrincipalPosts'); 
                    } 
                    else{

                        return view('Posts/EncargadoODP/EncargadoODP');
                    }


                } 
                else
                {
                return back()
                        ->withErrors(['Contraseña Incorrecta'])
                        ->withInput(request(['RUN']));
                }

            }
            else
            {
 
                $ID_Funcionario =  DB::table('Funcionarios')->select('ID_Funcionario_T')
                ->where('Rut', '=',$RUN)
                ->first();

                $LugarDeTrabajo =  DB::table('LugarDeTrabajo') 
                ->leftjoin('OficinaPartes', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'OficinaPartes.ID_OP_LDT') 
                ->select('id_Funcionario_OP','ID_Jefatura')
                ->where('ID_Funcionario_LDT', '=',$ID_Funcionario->ID_Funcionario_T)
                ->first();

                if (!empty($LugarDeTrabajo->ID_Jefatura))  
                { 
                    if (!empty($LugarDeTrabajo->id_Funcionario_OP))
                    { 
                        $idLogin=FuncionarioModels::Select('ID_Funcionario_T','Activo','Rut','password')->whereRut($RUN)->first();

                        if (!empty($idLogin->Rut) AND !empty($idLogin->Activo==1))
                        { 

                            if(Auth::attempt(['Rut' => $RUN, 'password' => $password], true))
                            {
                             
                                return view('Posts/Principal/PrincipalPosts');

                            } 
                            else
                            {
                            return back()
                                    ->withErrors(['Contraseña Incorrecta'])
                                    ->withInput(request(['RUN']));
                            }
                        }
                        elseif(!empty($idLogin->Rut) AND !empty($idLogin->Activo==0))
                        {
                            return back()
                                ->withErrors(['Usuario desactivado, o en espera de confirmación de ingreso.'])
                                ->withInput(request(['RUN']));
                        }
                        elseif(!empty($idLogin->Rut) AND !empty($idLogin->Activo==2))
                        {
                            return back()
                                ->withErrors(['Usuario desactivado.'])
                                ->withInput(request(['RUN']));
                        }
                        else
                        {
                            return back()
                                ->withErrors(['Usuario No Registrado'])
                                ->withInput(request(['RUN']));
                        }           
                    }
                    else  
                    {
                        $Nombre =  DB::table('Funcionarios') 
                        ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
                        ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
                        ->select('Nombre_DepDir')
                        ->where('Rut', '=',$RUN)
                        ->first(); 
                        
                        return back()
                        ->withErrors([$Nombre->Nombre_DepDir.' NO SE ENCUENTRA HABILITADO ACTUALMENTE.'])
                        ->withInput(request(['RUN']));
                    }
                }
                else 
                {
                    $Nombre =  DB::table('Funcionarios') 
                    ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT') 
                    ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir') 
                    ->select('Nombre_DepDir')
                    ->where('Rut', '=',$RUN)
                    ->first(); 
                    
                    return back()
                    ->withErrors([$Nombre->Nombre_DepDir.' NO SE ENCUENTRA HABILITADO ACTUALMENTE.'])
                    ->withInput(request(['RUN']));
                }
            }
        }
        else
        {
            return back()
                ->withErrors(['Usuario No Registrado'])
                ->withInput(request(['RUN']));
        }
    }
}
