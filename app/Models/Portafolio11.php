<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portafolio11 extends Model
{
    use HasFactory;

     //referencia a una tabla
     protected $table="Portafolio11";
     protected $primaryKey="ID_Documento_T";
 
     //pongo los caampos para permitir insert multiple
     protected $fillable=[
         "ID_Funcionario_Sol",
         "Estado_T",  
         "Titulo_T",
         "Fecha_T",
         "Anio"
     ];
}
