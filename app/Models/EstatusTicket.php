<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstatusTicket extends Model
{
    use HasFactory;

    protected $table = 'estatus_ticket';
    protected $primaryKey = 'id_estatus';

    protected $fillable = ['nombre_estatus'];
}
