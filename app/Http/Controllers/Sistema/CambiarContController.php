<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\FuncionarioModels;

class CambiarContController extends Controller
{
    public function index(Request $request)
    { 
        $rules = [
            'passwordActual' => 'required',
            'Contrasenia' => 'required',
            'Comfirmar_Contrasenia' => 'required:Contrasenia|same:Contrasenia|min:6|different:password',
        ];

        $messages = [
            'passwordActual.required' =>'El campo contraseña actual es obligatorio.',
            'Contrasenia.required' =>'El campo contraseña nueva es obligatorio.',
            'Comfirmar_Contrasenia.required' =>'El campo confirmar contraseña es obligatorio y debe ser igual al campo contraseña nueva.'
        ];

        $this->validate($request, $rules, $messages);

        $passwordActual = $request->input('passwordActual'); 
        $Contrasenia = $request->input('Contrasenia');  

        $Rut = Auth::user()->Rut;
        $Id_Funcionario = Auth::user()->ID_Funcionario_T;

		$FuncionarioPassword=FuncionarioModels::select('password')->whereRut($Rut)->get()->first();

		if(Hash::check($passwordActual, $FuncionarioPassword->password)){
		        
		        $user = FuncionarioModels::find($Id_Funcionario);
	            $user->password = Hash::make($request->Contrasenia);
	            $user->save();

			$resultado='Contraseña Actualizada Correctamente';
		}
		else{

 				return back()
                ->withErrors(['Contraseña actual es incorrecta'])
                ->withInput(request(['RUN']));
		}
   		
   		return view('Sistema/MostrarResultadoCambios')->with('resultado', $resultado);

 	}
}
