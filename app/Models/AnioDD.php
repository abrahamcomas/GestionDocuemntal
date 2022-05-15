<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnioDD extends Model
{
    use HasFactory;

    //referencia a una tabla
    protected $table="AnioDD";
    protected $primaryKey="ID_Anio";

    //pongo los caampos para permitir insert multiple
    protected $fillable=[
        "Anio_DD",
        "ID_DD",
        "Nombre",
        "Numero_DD"
    ];

    public $timestamps = false;
}
 