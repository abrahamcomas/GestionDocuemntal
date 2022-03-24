<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPlantillas extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="plantillas";
    protected $primaryKey="id_plantillas"; 

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
    	"nombre_plantilla",
    	"Ruta_T"
    ]; 
    
    public $timestamps = false;
}
