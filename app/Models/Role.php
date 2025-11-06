<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';          // Apunta a tu tabla 'roles'
    protected $primaryKey = 'id_rol';    // Usa la clave primaria correcta
    // Ya que tu tabla tiene created_at/updated_at, NO usamos $timestamps = false.

    protected $fillable = [
        'nombre_rol',
    ];
}