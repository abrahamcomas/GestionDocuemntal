<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkFirma extends Model
{
    use HasFactory;

     //referencia a una tabla
     protected $table="LinkFirma"; 
     protected $primaryKey="ID_LinkFirma"; 
 
     //pongo los caampos para permitir insert multiple
     protected $fillable=[
        "ID_Documento_L",
        "Titulo_T",       
        "ID_Funcionario_L",
        "Nombres_L",       
        "Apellidos_L",  
        "mousePosX",       
        "mousePosY",           
        "Pagina",           
        "Ancho",             
        "Alto",             
        "Token",            
        "Observacion",    
        "Contenido",   
        "Estado",
        "Email",
        "direccionEmail"
     ]; 
     
     public $timestamps = false;
}
