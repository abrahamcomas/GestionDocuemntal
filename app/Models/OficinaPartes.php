<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OficinaPartes extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="OficinaPartes";
    protected $primaryKey="Id_OP";
  
    //pongo los caampos para permitir insert multiple
    protected $fillable=[
          "ID_OP_LDT",
          "id_Funcionario_OP",
          "ID_Jefatura"
    ]; 
 
    public $timestamps = false;
}
