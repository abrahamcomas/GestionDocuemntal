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
                ->withErrors(['Usuario Desactivado'])
                ->withInput(request(['RUN']));
        }
        else
        {
            return back()
                ->withErrors(['Usuario No Registrado'])
                ->withInput(request(['RUN']));
        }

    }
}
