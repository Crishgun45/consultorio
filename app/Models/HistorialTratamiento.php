<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialTratamiento extends Model
{
    use HasFactory;

    protected $table = 'historial_tratamientos';
    protected $primaryKey = 'id'; // Ajustamos la clave primaria

    protected $fillable = [
        'id_cita',
        'id_tratamiento',
        'fecha_realizacion',
        'notas',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'id_tratamiento');
    }
}
