<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepDirecciones extends Model
{
    use HasFactory;

        //referencia a una tabla
        protected $table="DepDirecciones";
        protected $primaryKey="ID_DepDir";
  
        //pongo los caampos para permitir insert multiple
        protected $fillable=[
            "Nombre_DepDir",
            "EstadoDirDep"
        ]; 

        public $timestamps = false;
}
