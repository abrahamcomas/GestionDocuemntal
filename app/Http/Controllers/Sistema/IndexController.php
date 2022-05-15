<?php

namespace App\Http\Controllers\Sistema; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FirmadosDD; 
use App\Models\FirmadosFunc; 
use App\Models\AnioDD; 
use Illuminate\Support\Facades\DB; 

class IndexController extends Controller  
{
    public function index(Request $request)  
    {

 
        //dd(\Request::ip());
   
        $NumeroMes =date("n") - 1;
        $NumeroAnio =date("Y") - 1;

        $Funcionario = FirmadosFunc::where('Mes_Func', date("n"))->where('Anio_Func', date("Y"))->orderBy('NumeroFunc', 'DESC')->take(10)->get();

        if(sizeof($Funcionario)){
            foreach($Funcionario as $n){
                $puntosFuncionario[] =['name' => $n['Nombres'], 'y'=>floatval($n['NumeroFunc'])];
            }
        }
        else{

            $Funci = FirmadosFunc::where('Mes_Func', $NumeroMes)->where('Anio_Func', date("Y")) ->orderBy('NumeroFunc', 'DESC')->take(10)->get();
            foreach($Funci as $n){
                $puntosFuncionario[] =['name' => $n['Nombres'], 'y'=>floatval($n['NumeroFunc'])];
            } 
        }

        $FirmadosDD = FirmadosDD::where('Mes_DD', date("n"))->where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get();

        if(sizeof($FirmadosDD)){
            foreach($FirmadosDD as $navegador){
                
                $puntos[] =['name' => $navegador['Nombre'], 'y'=>floatval($navegador['Numero_DD'])];
            }
        }
        else{ 

            $FirDD = FirmadosDD::where('Mes_DD', $NumeroMes)->where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get();
            foreach($FirDD as $navegador){
                
                $puntos[] =['name' => $navegador['Nombre'], 'y'=>floatval($navegador['Numero_DD'])];
            }

        }

        $Anio = AnioDD::where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get(); 

        if(sizeof($Anio)){
            foreach($Anio as $navegador){
                $puntosAnio[] =['name' => $navegador['Nombre'], 'y'=>floatval($navegador['Numero_DD'])];
            }
        }
        else{  

            $A = AnioDD::where('Anio_DD', $NumeroAnio)->orderBy('Numero_DD', 'DESC')->take(10)->get();

            foreach($A as $navegador){
                
                $puntosAnio[] =['name' => $navegador['Nombre'], 'y'=>floatval($navegador['Numero_DD'])];
            }
        }

        $FuncionarioTodos = FirmadosFunc::where('Mes_Func', date("n"))->where('Anio_Func', date("Y"))->orderBy('NumeroFunc', 'DESC')->take(10)->get();

        $FirmadosDDTodos = FirmadosDD::where('Mes_DD', date("n"))->where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get();

        $AnioTodos = AnioDD::where('Anio_DD', date("Y"))->orderBy('Numero_DD', 'DESC')->take(10)->get();

        return view('Sistema/Principal',["DataFunc"=>json_encode($puntosFuncionario),"data"=>json_encode($puntos),"DatatAnio"=>json_encode($puntosAnio)])->with('FuncionarioTodos', $FuncionarioTodos)->with('FirmadosDDTodos', $FirmadosDDTodos)->with('AnioTodos', $AnioTodos);

    }
}
 