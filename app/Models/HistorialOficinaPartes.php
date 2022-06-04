<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialOficinaPartes extends Model
{
    use HasFactory;

      //referencia a una tabla
      protected $table="HistorialOficinaPartes";
      protected $primaryKey="id";
   
      //pongo los caampos para permitir insert multiple
      protected $fillable=[
           "Id_OP",
           "ID_OP_LDT",
           "id_Funcionario_OP",
           "ID_Jefatura",
           "Fecha"
      ]; 
   
      public $timestamps = false;
}
