<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreDocFunc extends Model
{
    use HasFactory;

     //referencia a una tabla
     protected $table="CreDocFunc";
     protected $primaryKey="id_CreDocFunc";
 
     //pongo los caampos para permitir insert multiple
     protected $fillable=[
         "Id_DocFunc_Cre",
         "ID_Funcionario_Cre",
         "Mensaje_Cre"

     ]; 

     public $timestamps = false;
}
