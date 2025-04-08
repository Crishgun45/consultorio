<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\HistorialTratamiento;
use App\Models\Tratamiento;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'totalPacientes' => Paciente::count(),
            'totalTratamientos' => HistorialTratamiento::count(),
            'totalCostoTratamientos' => Tratamiento::sum('costo'),
        ]);
    }
}
