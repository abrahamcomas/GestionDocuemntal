<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarDeTrabajo extends Model
{
    use HasFactory;

        //referencia a una tabla
        protected $table="LugarDeTrabajo";
        protected $primaryKey="ID_LugarDeTrabajo";
    
        //pongo los caampos para permitir insert multiple
        protected $fillable=[
            "ID_DepDirecciones_LDT",
            "ID_Funcionario_LDT",
            "Estado_LDT"
        ]; 

        public $timestamps = false;
}
