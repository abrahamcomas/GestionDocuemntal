<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\FuncionarioModels;
use App\Models\LugarDeTrabajo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Session;

class IngresoLugarController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'passwordActual' => 'required',
            'Lugar' => 'required', 
        ];
 
        $messages = [
            'passwordActual.required' =>'El campo "Contraseña actual" es obligatorio.',
            'Lugar.required' =>'El campo "LUGAR DE TRABAJO" es obligatorio.'
        ];
 
        $this->validate($request, $rules, $messages);
  		
  		$passwordActual = $request->input('passwordActual'); 
        $Lugar = $request->input('Lugar'); 
 
        $Rut = Auth::user()->Rut; 
        $Id_Funcionario = Auth::user()->ID_Funcionario_T; 

        $FuncionarioPassword=FuncionarioModels::select('password')->whereRut($Rut)->get()->first();

		if(Hash::check($passwordActual, $FuncionarioPassword->password)){

            $Lugares =  DB::table('DepDirecciones') 
            ->where('EstadoDirDep', '=', 1) 
            ->get();

            $LugarDeTrabajo=LugarDeTrabajo::where('ID_Funcionario_LDT', $Id_Funcionario)->first();
            $LugarDeTrabajo->ID_DepDirecciones_LDT = $Lugar;
            $LugarDeTrabajo->Estado_LDT = 0;
            $LugarDeTrabajo->save(); 

            $FuncionarioModels=FuncionarioModels::find($Id_Funcionario); 
            $FuncionarioModels->Activo = 0; 
            $FuncionarioModels->save(); 

            DB::table('sessions')->where('user_id', $Id_Funcionario)->delete(); 

                Auth::logout();
                Session::flush();
               return Redirect::to('/');
        }
        else{

                return back()
                    ->withErrors(['Contraseña actual es incorrecta'])
                    ->withInput(request(['RUN']));
        }
                
               return view('Sistema/CambiarLugar/CambiarLugar')->with('resultado', $resultado)->with('Lugares', $Lugares);
    
    }
}
 