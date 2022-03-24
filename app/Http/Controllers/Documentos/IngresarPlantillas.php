<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MPlantillas;
use Illuminate\Support\Facades\Storage;

class IngresarPlantillas extends Controller
{
    public function index(Request $request)
    {   
        $word  = $request->file('word');
        
        $codificado = Storage::disk('WORD')->put('', $word);

        $DestinoDocumento                   = new MPlantillas;
        $DestinoDocumento->nombre_plantilla  = $word->getClientOriginalName(); 
        $DestinoDocumento->Ruta_T           = $codificado;   
        $DestinoDocumento->save(); 
  
        $Resultado='Plantilla subida correctamente.';

        return view('Plantillas/Resultado')->with('Resultado', $Resultado);
   
    }
}
 