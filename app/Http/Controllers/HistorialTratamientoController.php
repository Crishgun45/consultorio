<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HistorialTratamiento;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistorialTratamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historialTratamientos = HistorialTratamiento::with('cita.paciente')->get();

        return Inertia::render('HistorialTratamientos/Index', [
            'historialtratamientos' => $historialTratamientos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());  // Esto es solo para depuración, luego eliminarlo
        $validated = $request->validate([
            'id_cita' => 'required|exists:citas,id',
            'fecha_realizacion' => 'required|date',
            'notas' => 'nullable|string',
        ]);

        // Crear el nuevo historial de tratamiento
        HistorialTratamiento::create($validated);

        return redirect()->route('historialTratamientos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
