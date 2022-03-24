<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

       //referencia a una tabla
       protected $table="TipoDocumento";
       protected $primaryKey="ID_TipoDocumento_T";
   
       //pongo los caampos para permitir insert multiple
       protected $fillable=[
           "Nombre_T",
           "EstadoTipoDocumento"
       ]; 
       
       public $timestamps = false;
}
