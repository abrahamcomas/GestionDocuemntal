<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurarContrasenia extends Controller
{
    public function index(Request $request)
    {

    	$id = $request->input('id');
    	$token = $request->input('token'); 
        $CorreoActivo = 2; 

    	if (isset($id) AND isset($token)) {  
  
				$Datos=DB::table('Funcionarios')->Select('ID_Funcionario','Nombres','Apellidos','CorreoActivo','Token')->where('ID_Funcionario',$id)->first();
    	 
    			if ($Datos->Token==$token AND $Datos->CorreoActivo==$CorreoActivo){
    				return view('Email/TokenValido')->with('Datos', $Datos);
    			}	 
    			else{
					return view('Email/ErrorValidarToken')->with('Datos', $Datos);
    			} 
		}
		else{
			return view('Email/ErrorTokenEditado');
		}
    }
}
