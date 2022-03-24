<?php
 
namespace App\Http\Controllers\Externos; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\DocumentosExterno; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash; 
use JWTAuth; 
use Tymon\JWTAuth\Exceptions\JWTException; 
use Illuminate\Http\File;
use App\Models\solofirma;  
use Response;
use Illuminate\Support\Facades\DB;    
 
class SubirPDFController extends Controller
{ 
    public function index(Request $request)  
    {  

        $Ruta = $request->input('Ruta');   

        session(['Ruta' => $Ruta]);  

        $NombreZip =  DB::table('DocumentosExterno')->select('NombreZip')->where('Ruta_T', '=',$Ruta )->first();
        
        $NombreZip =$NombreZip->NombreZip;

        $Cuantos =  DB::table('DocumentosExterno')->select('NombreZip')->where('NombreZip', '=',$NombreZip )->get();


        $cuantos=count($Cuantos);

        $horaInicial = date('h:i');  
        $minutoAnadir=$cuantos*30;
 
        $segundos_horaInicial=strtotime($horaInicial);
        
        $nuevaHora=date("H:i",$segundos_horaInicial+$minutoAnadir); 
           
        return view('Posts/Externo/DocumentoExterno')->with('cuantos', $cuantos)->with('nuevaHora', $nuevaHora); 

    }
}
