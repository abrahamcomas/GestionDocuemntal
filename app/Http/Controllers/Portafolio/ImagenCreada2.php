<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use App\Models\ImagenFirma;

class ImagenCreada2 extends Controller
{
    public function index(Request $request)  
    {

        $data  = $request->input('Firma');  

        list($type, $data) = explode(';', $data); 
        list(, $data) = explode(',', $data); 
        $data = base64_decode($data);
 
        $Funcionario  =  Auth::user()->ID_Funcionario_T;
        $Nombre  =  Auth::user()->ID_Funcionario_T.'.png';
 
        Storage::disk('Firmas')->put($Nombre, $data);   

        $ImagenFirma                    = new ImagenFirma;
        $ImagenFirma->id_Funcionario_T  = $Funcionario;
        $ImagenFirma->Ruta              = $Nombre;
        $ImagenFirma->save(); 

        return view('Posts/Portafolio/NuevoPortafolio'); 
    } 

    public function index2(Request $request)  
    {

        $data  = $request->input('Firma');  

        list($type, $data) = explode(';', $data); 
        list(, $data) = explode(',', $data); 
        $data = base64_decode($data);
 
        $Funcionario  =  Auth::user()->ID_Funcionario_T;
        $Nombre  =  Auth::user()->ID_Funcionario_T.'.png';
 
        Storage::disk('Firmas')->put($Nombre, $data);   

        $ImagenFirma                    = new ImagenFirma;
        $ImagenFirma->id_Funcionario_T  = $Funcionario;
        $ImagenFirma->Ruta              = $Nombre;
        $ImagenFirma->save();

        return view('Posts/Portafolio/Recibidos'); 
    }

    public function index4(Request $request)  
    {

        $data  = $request->input('Firma');  

        list($type, $data) = explode(';', $data); 
        list(, $data) = explode(',', $data); 
        $data = base64_decode($data);
 
        $Funcionario  =  Auth::user()->ID_Funcionario_T;
        $Nombre  =  Auth::user()->ID_Funcionario_T.'.png';
 
        Storage::disk('Firmas')->put($Nombre, $data);   

        $ImagenFirma                    = new ImagenFirma;
        $ImagenFirma->id_Funcionario_T  = $Funcionario;
        $ImagenFirma->Ruta              = $Nombre;
        $ImagenFirma->save();

        return view('Posts/EncargadoODP/PortafolioDirecto'); 
    }

    public function index5(Request $request)  
    {

        $data  = $request->input('Firma');  
        $ID_Funcionario_T  = $request->input('SelecID_Funcionario_T'); 
        
        list($type, $data) = explode(';', $data); 
        list(, $data) = explode(',', $data); 
        $data = base64_decode($data); 
 

        $Nombre  =  Auth::user()->ID_Funcionario_T.'.png';
 
        Storage::disk('Firmas')->put($Nombre, $data);   

        $ImagenFirma                    = new ImagenFirma;
        $ImagenFirma->id_Funcionario_T  = $ID_Funcionario_T;
        $ImagenFirma->Ruta              = $Nombre;
        $ImagenFirma->save();

        return view('Posts/Solicitudes/Solicitudes'); 
    }
}
