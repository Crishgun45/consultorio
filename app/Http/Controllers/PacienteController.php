<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::all();
        return Inertia::render('Pacientes/Index', [
            'pacientes' => $pacientes,
        ]);
    }

    public function create()
    {
        return Inertia::render('Pacientes/Create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido_paterno' => 'required|string|max:255',
        'apellido_materno' => 'nullable|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'direccion' => 'nullable|string|max:500',
        'telefono' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255|unique:pacientes',
        'historial_medico' => 'nullable|string',
    ]);

    Paciente::create($validated);
    return redirect()->route('pacientes.index');
}

    public function show(Paciente $paciente)
    {
        return Inertia::render('Pacientes/Show', [
            'paciente' => $paciente,
        ]);
    }

    public function edit(Paciente $paciente)
    {
        return Inertia::render('Pacientes/Edit', [
            'paciente' => $paciente,
        ]);
    }

    public function update(Request $request, Paciente $paciente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'nullable|string|max:500',
            'telefono' => 'nullable|string|max:20',
            'email' => "nullable|email|max:255|unique:pacientes,email,{$paciente->id}",
            'historial_medico' => 'nullable|string',
        ]);

        $paciente->update($validated);
        return redirect()->route('pacientes.index');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index');
    }
}
