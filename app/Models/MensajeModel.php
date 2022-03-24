<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeModel extends Model
{
    use HasFactory;

      //referencia a una tabla
      protected $table="Mensaje";
      protected $primaryKey="id_Mensaje";
  
      //pongo los caampos para permitir insert multiple
      protected $fillable=[
          "Mensaje",
          "FechaInicio",
          "Estado",
      ]; 

      public $timestamps = false;
}
