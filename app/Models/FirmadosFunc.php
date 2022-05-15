<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmadosFunc extends Model
{
    use HasFactory;

     //referencia a una tabla
     protected $table="FirmadosFunc";
     protected $primaryKey="ID_FirmadosFunc";
 
     //pongo los caampos para permitir insert multiple
     protected $fillable=[
         "Mes_Func",
         "Anio_Func",
         "ID_Func",
         "Nombres",
         "NumeroFunc"
     ]; 

     public $timestamps = false;
}
