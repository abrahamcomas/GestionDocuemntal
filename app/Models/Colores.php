<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colores extends Model
{
    use HasFactory;

        //referencia a una tabla
        protected $table="Colores";
        protected $primaryKey="ID_Color";
    
        //pongo los caampos para permitir insert multiple
        protected $fillable=[
            "ID_Funcionario",
            "ColorPrincipal",
            "ColorSecundario",
            "BodyPrincipal",
            "BodySecundario", 
            "FocoNoSelecLetra",
            "FocoNoSelecFondo",
            "FocoSelecLetra",
            "FocoSelecFondo",
            "LetraLista",
            "LetraPrincipal"
        ]; 
    
        public $timestamps = false;
}
