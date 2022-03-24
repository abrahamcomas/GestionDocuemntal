<?php

namespace App\Http\Controllers\Sessiones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sessions;
use Illuminate\Support\Facades\DB;

class EliminarVinculo extends Controller
{
    public function index(Request $request)  
    {
	 
        $id = $request->input('id'); 

        $sessiones = DB::table('sessions')
        ->where('id', $id)
        ->delete();
     
        return view('Vinculados/Resultado')->with('sessiones', $sessiones);
    }
}
