<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HistorialTratamiento;
use App\Models\Paciente;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CitaController extends Controller
{

    public function index()
    {
        $citas = Cita::with('paciente')->get();
        return Inertia::render('Citas/Index', ['citas' => $citas]);
    }
    public function create()
    {
        $pacientes = Paciente::all();
        $tratamientos = Tratamiento::all(); // Obtén todos los tratamientos
        return Inertia::render('Citas/Create', ['pacientes' => $pacientes, 'tratamientos' => $tratamientos]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_paciente' => 'required|exists:pacientes,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string',
            'estado' => 'required|string',
        ]);

        Cita::create($request->all());

        return redirect()->route('citas.index');
    }

    public function show(Cita $cita)
    {
        $cita->load('paciente', 'tratamientos', 'pagos');
        return Inertia::render('Citas/Show', ['cita' => $cita]);
    }
    public function edit(Cita $cita)
    {
        $pacientes = Paciente::all();
        $tratamientos = Tratamiento::all(); // Obtén todos los tratamientos
        return Inertia::render('Citas/Edit', ['cita' => $cita, 'pacientes' => $pacientes, 'tratamientos' => $tratamientos]);
    }
    public function update(Request $request, Cita $cita)
    {
        $validated = $request->validate([
            'id_paciente' => 'required|exists:pacientes,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string',
            'estado' => 'required|string',
        ]);

        $cita->update($validated);

        // Si la cita ha sido marcada como 'Realizada', registrar en historial_tratamientos
        if ($validated['estado'] === 'Realizada') {
            HistorialTratamiento::create([
                'id_cita' => $cita->id, // Guardamos el motivo en lugar del tratamiento
                'fecha_realizacion' => now(),
                'notas' => 'Tratamiento realizado.',
            ]);
        }

        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();

        return redirect()->route('citas.index');
    }
}
