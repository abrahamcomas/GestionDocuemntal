<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenFirma extends Model
{
    use HasFactory;

       //referencia a una tabla
       protected $table="ImagenFirma";
       protected $primaryKey="ID_Imagen";
   
       //pongo los caampos para permitir insert multiple
       protected $fillable=[
           "id_Funcionario_T",
           "Ruta"
       ]; 

       public $timestamps = false;
}
