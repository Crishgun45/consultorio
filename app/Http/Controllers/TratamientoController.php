<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TratamientoController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamiento::all();
        return Inertia::render('Tratamientos/Index', [
            'tratamientos' => $tratamientos,
        ]);
    }
    public function create()
    {
        return Inertia::render('Tratamientos/Create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'required|string|max:255',
        'costo' => 'required',

    ]);

    Tratamiento::create($validated);
    return redirect()->route('tratamientos.index');
}

    public function show(Tratamiento $tratamiento)
    {
        return Inertia::render('Tratamientos/Show', [
            'tratamiento' => $tratamiento,
        ]);
    }

    public function edit(Tratamiento $tratamiento)
    {
        return Inertia::render('Tratamientos/Edit', [
            'tratamiento' => $tratamiento,
        ]);
    }

    public function update(Request $request, Tratamiento $tratamiento)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'costo' => 'required',
        ]);

        $tratamiento->update($validated);
        return redirect()->route('tratamientos.index');
    }

    public function destroy(Tratamiento $tratamiento)
    {
        $tratamiento->delete();
        return redirect()->route('tratamientos.index');
    }
}
