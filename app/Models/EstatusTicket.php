<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GestionTicket;

class EstatusTicket extends Model
{
    use HasFactory;

    protected $table = 'estatus_ticket';
    protected $primaryKey = 'id_estatus';

    protected $fillable = ['nombre_estatus'];

    // Accessor para compatibilidad - permite usar $estatus->nombre
    public function getNombreAttribute()
    {
        return $this->nombre_estatus;
    }

    // Relación con tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_estatus', 'id_estatus');
    }

    //Relación con el jefe
    public function gestionTickets()
    {
        return $this->hasMany(GestionTicket::class, 'id_estatus', 'id_estatus');
    }
}