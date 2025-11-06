<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'id_ticket';

    protected $fillable = [
        'titulo',
        'description', // CORREGIDO: cambiar 'descripcion' por 'description'
        'fecha_creacion',
        'fecha_finalizacion',
        'id_usuario',
        'id_auxiliar',
        'id_departamento',
        'id_estatus',
        'id_jefe',
        'fecha_asignacion',
        'evidencia'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_finalizacion' => 'datetime',
        'fecha_asignacion' => 'datetime',
    ];

    // Relación con el usuario que creó el ticket
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    // Relación con el auxiliar asignado
    public function asignado()
    {
        return $this->belongsTo(User::class, 'id_auxiliar', 'id_usuario');
    }

    // Relación con el jefe
    public function jefe()
    {
        return $this->belongsTo(User::class, 'id_jefe', 'id_usuario');
    }

    // Relación con el departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    // Relación con el estatus
    public function estatus()
    {
        return $this->belongsTo(EstatusTicket::class, 'id_estatus', 'id_estatus');
    }

    // Relación con reportes
    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'id_ticket', 'id_ticket');
    }
}