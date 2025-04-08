<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cita',
        'fecha_pago',
        'monto',
        'metodo_pago',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }
}
