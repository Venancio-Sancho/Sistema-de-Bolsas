<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // Listar departamentos
    public function index()
    {
        $departments = Department::with('faculty')->get();
        $faculties = Faculty::all(); // necessário para os modais
        return view('departments.index', compact('departments', 'faculties'));
    }

    // Guardar novo departamento
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id_faculty',
            'description' => 'nullable|string',
        ]);

        Department::create([
            'department_name' => $request->department_name,
            'faculty_id' => $request->faculty_id,
            'description' => $request->description,
        ]);

        return redirect()->route('departments.index')->with('success', 'Departamento criado com sucesso.');
    }

    // Atualizar departamento
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id_faculty',
            'description' => 'nullable|string',
        ]);

        $department->update([
            'department_name' => $request->department_name,
            'faculty_id' => $request->faculty_id,
            'description' => $request->description,
        ]);

        return redirect()->route('departments.index')->with('success', 'Departamento atualizado com sucesso.');
    }

    // Deletar departamento
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Departamento eliminado com sucesso.');
    }
}
