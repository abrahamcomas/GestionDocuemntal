<?php

namespace App\Http\Controllers\CrearDocumento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  


class NuevoDocumentoController extends Controller
{
    public function index(){

        $plantillas =  DB::table('plantillas')->get(); 

        return view('CrearDocumento/NuevoDocumento')->with('plantillas', $plantillas);
    }
}
 