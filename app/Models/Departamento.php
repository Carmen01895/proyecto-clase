<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    
    protected $table = 'departamentos';          // Apunta a tu tabla 'departamentos'
    protected $primaryKey = 'id_departamento';   // Usa la clave primaria correcta
    // La tabla tiene created_at/updated_at, así que NO declaramos $timestamps = false.

    protected $fillable = [
        'nombre_departamento', // Columna del nombre
    ];
}