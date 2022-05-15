<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoPlantilla extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="PlantillasCredas";
    protected $primaryKey="id_plantillas";

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "id_funcionario",
        "nombre_plantilla",
        "text_plantilla"
    ]; 

    public $timestamps = false;
}
 