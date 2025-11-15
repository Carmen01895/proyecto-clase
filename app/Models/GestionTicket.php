<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Departamento;
use App\Models\EstatusTicket;

class GestionTicket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'id_ticket';

    protected $fillable = [
        'titulo',
        'descripcion',
        'id_usuario',
        'id_auxiliar',
        'id_departamento',
        'id_estatus',
        'id_jefe',
        'fecha_asignacion',
        'fecha_creacion',
        'evidencia'
    ];

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function auxiliar()
    {
        return $this->belongsTo(User::class, 'id_auxiliar', 'id_usuario');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function estatus()
    {
        return $this->belongsTo(EstatusTicket::class, 'id_estatus', 'id_estatus');
    }
}
