<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmadosDD extends Model
{
    use HasFactory;  

      //referencia a una tabla
      protected $table="FirmadosDD";
      protected $primaryKey="ID_FIRMADOSDD";
  
      //pongo los caampos para permitir insert multiple
      protected $fillable=[
          "Mes_DD",
          "Anio_DD",
          "ID_DD",
          "Numero_DD",
          "Nombre"
      ];

      public $timestamps = false;
}
