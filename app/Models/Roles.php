<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

        //referencia a una tabla
        protected $table="Roles";
        protected $primaryKey="Id_Roles";
    
        //pongo los caampos para permitir insert multiple
        protected $fillable=[
            "id_Funcionario_Roles",
            "Navegador"
        ]; 
 
        public $timestamps = false;
}
