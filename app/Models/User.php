<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Departamento;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios'; 
    
    protected $primaryKey = 'id_usuario'; 
    
    /**
     * The attributes that are mass assignable.
     * Estos son los campos de tu tabla 'usuarios'.
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'correo',       
        'puesto',
        'password',
        'foto_perfil',
        'id_departamento',
        'id_rol',       
        'fecha_registro',
        'activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed', 
        ];
    }

    public function departamento()
    {
        
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }
}