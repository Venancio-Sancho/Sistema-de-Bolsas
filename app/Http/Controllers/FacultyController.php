<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    // Mostrar lista de faculties
    public function index()
    {
        $faculties = Faculty::all();
        return view('faculties.index', compact('faculties'));
    }

    // Guardar nova faculty
    public function store(Request $request)
    {
        $request->validate([
            'faculty_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Faculty::create([
            'faculty_name' => $request->faculty_name,
            'description' => $request->description,
        ]);

        return redirect()->route('faculties.index')->with('success', 'Faculdade criada com sucesso.');
    }

    // Atualizar faculty
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'faculty_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $faculty->update([
            'faculty_name' => $request->faculty_name,
            'description' => $request->description,
        ]);

        return redirect()->route('faculties.index')->with('success', 'Faculdade atualizada com sucesso.');
    }

    // Deletar faculty
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('faculties.index')->with('success', 'Faculdade eliminada com sucesso.');
    }
}
