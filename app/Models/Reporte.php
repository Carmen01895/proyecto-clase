<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    // Modelo mínimo para compatibilidad con relaciones.
    protected $table = 'reportes';
    // No asumimos la clave primaria ni columnas específicas aquí.
}
