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
        'descripcion',
        'id_usuario',
        'id_estatus',
        'evidencia',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function estatus()
    {
        return $this->belongsTo(EstatusTicket::class, 'id_estatus', 'id_estatus');
    }
}
