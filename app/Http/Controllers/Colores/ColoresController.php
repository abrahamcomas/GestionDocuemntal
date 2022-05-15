<?php

namespace App\Http\Controllers\Colores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;  

class ColoresController extends Controller
{
    public function Ingresar(Request $request){


        $ColorPrincipal   = $request->input('ColorPrincipal');
        $ColorSecundario   = $request->input('ColorSecundario');
        $BodyPrincipal   = $request->input('BodyPrincipal');
        $BodySecundario   = $request->input('BodySecundario');
        $FocoNoSelecLetra   = $request->input('FocoNoSelecLetra');
        $FocoNoSelecFondo   = $request->input('FocoNoSelecFondo');
        $FocoSelecLetra   = $request->input('FocoSelecLetra');
        $FocoSelecFondo   = $request->input('FocoSelecFondo');
        $LetraLista   = $request->input('LetraLista');
        $LetraPrincipal   = $request->input('LetraPrincipal');
    
        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

        $Existe =  DB::table('Colores')->select('ID_Funcionario')->where('ID_Funcionario', '=',$ID_Funcionario)->first();

        if(empty($Existe->ID_Funcionario)){
             
            $Colores                  = new Colores; 
            $Colores->ID_Funcionario  = $ID_Funcionario;
            $Colores->ColorPrincipal  = $ColorPrincipal;
            $Colores->ColorSecundario = $ColorSecundario;
            $Colores->BodyPrincipal   = $BodyPrincipal;
            $Colores->BodySecundario  = $BodySecundario;
            $Colores->FocoNoSelecLetra   = $FocoNoSelecLetra;
            $Colores->FocoNoSelecFondo  = $FocoNoSelecFondo;
            $Colores->FocoSelecLetra   = $FocoSelecLetra;
            $Colores->FocoSelecFondo  = $FocoSelecFondo;
            $Colores->LetraLista  = $LetraLista;
            $Colores->LetraPrincipal = $LetraPrincipal; 
            $Colores->save();
 
        }
        else{  

            $Colores = Colores::where('ID_Funcionario', $ID_Funcionario)->first();
            
            if($ColorPrincipal!=""){
                $Colores->ColorPrincipal  = $ColorPrincipal;
            }
            if($ColorPrincipal!=""){
                $Colores->ColorSecundario = $ColorSecundario;
            }
            if($ColorSecundario!=""){
                $Colores->BodyPrincipal   = $BodyPrincipal;
            }
            if($BodySecundario!=""){
                $Colores->BodySecundario  = $BodySecundario;
            }
            if($FocoNoSelecLetra!=""){
                $Colores->FocoNoSelecLetra   = $FocoNoSelecLetra;
            }
            if($FocoNoSelecFondo!=""){
                $Colores->FocoNoSelecFondo  = $FocoNoSelecFondo;
            }
            if($FocoSelecLetra!=""){
                $Colores->FocoSelecLetra   = $FocoSelecLetra;
            }
            if($FocoSelecFondo!=""){
                $Colores->FocoSelecFondo  = $FocoSelecFondo;
            }
            if($LetraLista!=""){
                $Colores->LetraLista  = $LetraLista;
            }
            if($LetraPrincipal!=""){
                $Colores->LetraPrincipal = $LetraPrincipal; 
            }
            $Colores->save();
        }

        $Colores =  DB::table('Colores') 
        ->where('ID_Funcionario', '=',$ID_Funcionario) 
        ->first(); 
         
        if (!empty($Colores->ColorPrincipal)){
            $ColorPrincipal   = $Colores->ColorPrincipal; 
            session(['ColorPrincipal' => $ColorPrincipal]); 
        }

        if (!empty($Colores->ColorSecundario)){
            $ColorSecundario  = $Colores->ColorSecundario;
            session(['ColorSecundario' => $ColorSecundario]);  
        }

        if (!empty($Colores->BodyPrincipal)){
            $BodyPrincipal    = $Colores->BodyPrincipal; 
            session(['BodyPrincipal' => $BodyPrincipal]);
        }

        if (!empty($Colores->BodySecundario)){
            $BodySecundario   = $Colores->BodySecundario;
            session(['BodySecundario' => $BodySecundario]);  
        }   
            
        if (!empty($Colores->FocoNoSelecLetra)){
            $FocoNoSelecLetra = $Colores->FocoNoSelecLetra; 
            session(['FocoNoSelecLetra' => $FocoNoSelecLetra]); 
        }  

        if (!empty($Colores->FocoNoSelecFondo)){
            $FocoNoSelecFondo = $Colores->FocoNoSelecFondo;
            session(['FocoNoSelecFondo' => $FocoNoSelecFondo]);
        }  
           
        if (!empty($Colores->FocoSelecLetra)){
            $FocoSelecLetra = $Colores->FocoSelecLetra;
            session(['FocoSelecLetra' => $FocoSelecLetra]);
        }

        if (!empty($Colores->FocoSelecFondo)){
            $FocoSelecFondo = $Colores->FocoSelecFondo;
            session(['FocoSelecFondo' => $FocoSelecFondo]);
        } 

        if (!empty($Colores->LetraLista)){
            $LetraLista       = $Colores->LetraLista;
            session(['LetraLista' => $LetraLista]);
        }   
        
        if (!empty($Colores->LetraPrincipal)){
            $LetraPrincipal  = $Colores->LetraPrincipal;
            session(['LetraPrincipal' => $LetraPrincipal]);  
        }

        return view('Colores/Colores')->with('ColorPrincipal', $ColorPrincipal)->with('ColorSecundario', $ColorSecundario)->with('BodyPrincipal', $BodyPrincipal)
        ->with('BodySecundario', $BodySecundario)->with('FocoNoSelecLetra', $FocoNoSelecLetra)->with('FocoNoSelecFondo', $FocoNoSelecFondo)->with('FocoSelecLetra', $FocoSelecLetra)
        ->with('FocoSelecFondo', $FocoSelecFondo)->with('LetraLista', $LetraLista)->with('LetraPrincipal', $LetraPrincipal);
    }

    public function Borrar(Request $request){


        $ID_Funcionario  =  Auth::user()->ID_Funcionario_T; 

        $Existe =  DB::table('Colores')->select('ID_Funcionario')->where('ID_Funcionario', '=',$ID_Funcionario)->first();

        if(!empty($Existe->ID_Funcionario)){

            $Borrar = Colores::where('ID_Funcionario', $ID_Funcionario)->first();
            $Borrar->delete();

            session()->forget('ColorPrincipal');
            session()->forget('ColorSecundario');
            session()->forget('BodyPrincipal');
            session()->forget('BodySecundario');
            session()->forget('FocoNoSelecLetra');
            session()->forget('FocoNoSelecFondo');
            session()->forget('FocoSelecLetra');
            session()->forget('FocoSelecFondo');
            session()->forget('LetraLista');
            session()->forget('LetraPrincipal');

       
        }

        $ColorPrincipal  = "#09818F";
        $ColorSecundario = "#000000";
        $BodyPrincipal   = "#8AB3D3";
        $BodySecundario  = "#FFFFFF";
        $FocoNoSelecLetra   = "#56FF02";
        $FocoNoSelecFondo  = "#0E8B85";
        $FocoSelecLetra   = "#FFFFFF";
        $FocoSelecFondo  = "#0E8B85";
        $LetraLista  = "#56FF02";
        $LetraPrincipal = "#FFFFFF"; 
        return view('Colores/Colores')->with('ColorPrincipal', $ColorPrincipal)->with('ColorSecundario', $ColorSecundario)->with('BodyPrincipal', $BodyPrincipal)
        ->with('BodySecundario', $BodySecundario)->with('FocoNoSelecLetra', $FocoNoSelecLetra)->with('FocoNoSelecFondo', $FocoNoSelecFondo)->with('FocoSelecLetra', $FocoSelecLetra)
        ->with('FocoSelecFondo', $FocoSelecFondo)->with('LetraLista', $LetraLista)->with('LetraPrincipal', $LetraPrincipal);
    }     
}
