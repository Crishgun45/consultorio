<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_paciente',
        'fecha_hora',
        'motivo',
        'estado',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_cita'); // Si 'id_cita' es diferente en la tabla pagos, cámbiala aquí
    }
}
