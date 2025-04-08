<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
    ];

    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'historial_tratamientos', 'id_tratamiento', 'id_cita')->withPivot('fecha_realizacion', 'notas');
    }
}
