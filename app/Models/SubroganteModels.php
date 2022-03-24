<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubroganteModels extends Model
{
    use HasFactory;
    //referencia a una tabla
    protected $table="Subrogante";
    protected $primaryKey="Id_subrogante";

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "Activo",
        "Id_Subrogante_S",
        "Id_Subrogante_O",
        "Date_Inicio",
        "Date_Final"
    ]; 

    public $timestamps = false;
}
