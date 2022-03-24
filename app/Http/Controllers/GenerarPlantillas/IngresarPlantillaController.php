<?php

namespace App\Http\Controllers\GenerarPlantillas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;

class IngresarPlantillaController extends Controller
{
    public function index(Request $request){   

        $Ruta = $request->input('Ruta');

        session(['Ruta' => $Ruta]);  

        $NombreZip =  DB::table('plantillas')->select('Ruta_T')->where('Ruta_T', '=',$Ruta)->first();
        
           
        return view('Posts/GeneradorPlantillas/GenerarPlantillas');  
    } 
}
