<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoDocumento2 extends Model
{
    use HasFactory;

     //referencia a una tabla
     protected $table="DestinoDocumento2";
     protected $primaryKey="ID";
 
     //pongo los caampos para permitir insert multiple
     protected $fillable=[
         "ID_FSube",
         "Token",
         "FechaFirma"
     ]; 

     public $timestamps = false;
}
