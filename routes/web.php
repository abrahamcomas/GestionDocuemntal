<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\Registro;
use App\Http\Controllers\Login\Login;
use App\Http\Controllers\Login\Cerrar;
use App\Http\Controllers\Login\ResetearContrasenia;
use App\Http\Controllers\Login\RestaurarContrasenia;
use App\Http\Controllers\Login\NuevaContrasenia;

use App\Http\Controllers\Documentos\PDFGestionController;
use App\Http\Controllers\Documentos\FirmarDocumentoController;
use App\Http\Controllers\Documentos\FirmarDocumentoController2;

use App\Http\Controllers\Externos\FirmarDocumento;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/








Route::get('/', function () {
    if(Auth::guard('web')->check()){
        return view('Sistema/Principal');
    }else{
        return view('Login/Login');
    }
});
//PAGINA PRINCIPAL LOGIN 
Route::post('/', [Login::class, 'index'])->name('Login'); 

//Volver Principal
Route::get('/', function () {
    return view('Login/Login');
})->name('Index'); 

// REGISTRO
Route::patch('IngresoRegistro', [Registro::class, 'index'])->name('Registro');
Route::get('Registro', function () {
    return view('Registro/Registrarse');
})->name('Registrarse');

//CERRAR SESION 
Route::get('CerrarSesion', [Cerrar::class, 'index'])->name('CerrarSesion');
 

//RESTAURAR CONTRASEÑA POR CORREO
Route::patch('Restaurar', [NuevaContrasenia::class, 'index'])->name('Restaurar');
Route::post('Login/RecuperarContrasenia', [ResetearContrasenia::class, 'index'])->name('ContraseniaEnviada');
Route::get('ResetearContrasenia', [RestaurarContrasenia::class, 'index']);
Route::get('RecuperarContrasenia', function (){ 
    return view('Login/RecuperarContrasenia');
})->name('Recuperar');  



Route::post('/FirmarExterno', [FirmarDocumento::class, 'index'])->middleware('auth')->name('FirmarExterno');   

Route::post('/Firmar', [FirmarDocumentoController::class, 'index'])->middleware('auth')->name('Firmar');   
Route::post('/Firmar2', [FirmarDocumentoController2::class, 'index'])->middleware('auth')->name('Firmar2');   


Route::post('/Documento', [PDFGestionController::class, 'index'])->middleware('auth')->name('MostrarPDF');   


Route::post('/CrearDocumento',function () { 
    return view('Posts/Documentos/DocumentosNuevosPosts');
})->middleware('auth')->name('CrearDocumento');

Route::get('/CrearDocumento',function () { 
    return view('Posts/Documentos/DocumentosNuevosPosts');
})->middleware('auth')->name('CrearDocumento');

Route::post('/Distribuccion',function () { 
    return view('Posts/Documentos/DocumentosEnProcesoPosts');
})->middleware('auth')->name('Distribuccion');

Route::get('/Distribuccion',function () { 
    return view('Posts/Documentos/DocumentosEnProcesoPosts');
})->middleware('auth')->name('Distribuccion');

Route::post('/DocumentosDeEntrada',function () { 
    return view('Posts/Documentos/DocumentosDeEntradaPosts');
})->middleware('auth')->name('DocumentosDeEntrada');

Route::get('/DocumentosDeEntrada',function () { 
    return view('Posts/Documentos/DocumentosDeEntradaPosts');
})->middleware('auth')->name('DocumentosDeEntrada');

Route::post('/DocumentosFinalizados',function () { 
    return view('Posts/Documentos/DocumentosFinalizadosPosts');
})->middleware('auth')->name('DocumentosFinalizados'); 

Route::get('/DocumentosFinalizados',function () { 
    return view('Posts/Documentos/DocumentosFinalizadosPosts');
})->middleware('auth')->name('DocumentosFinalizados'); 

Route::post('/DocumentosAvisos',function () { 
    return view('Posts/Documentos/DocumentosAvisos');
})->middleware('auth')->name('DocumentosAvisos'); 

Route::get('/DocumentosAvisos',function () { 
    return view('Posts/Documentos/DocumentosAvisos');
})->middleware('auth')->name('DocumentosAvisos'); 





Route::get('/Menu',function () { 
    return view('Posts/Principal/PrincipalPosts');
})->middleware('auth')->name('Principal'); 



Route::post('/FirmarDocumentoExterno',function () { 
    return view('DocumentosExt/FirmarDocumento');
})->middleware('auth')->name('DocumentoExt'); 

Route::get('/FirmarDocumentoExterno',function () { 
    return view('DocumentosExt/FirmarDocumento');
})->middleware('auth')->name('DocumentoExt'); 



