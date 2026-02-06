<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('curso.faculty')->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::with('department.faculty')->get();
        return view('students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_completo' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|in:Masculino,Feminino',
            'email' => 'required|email|unique:students,email',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string',
            'senha' => 'required|string|min:6',
            'id_curso' => 'nullable|exists:courses,id_course',
            'tipo_estudante' => 'required|in:Interno,Externo',
        ]);

        Student::create([
            'nome_completo' => $request->nome_completo,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'senha' => Hash::make($request->senha),
            'id_curso' => $request->id_curso,
            'tipo_estudante' => $request->tipo_estudante,
        ]);

        return redirect()->route('students.index')->with('success', 'Estudante criado com sucesso.');
    }

    public function edit(Student $student)
    {
        $courses = Course::with('department.faculty')->get();
        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nome_completo' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|in:Masculino,Feminino',
            'email' => 'required|email|unique:students,email,' . $student->id_estudante . ',id_estudante',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string',
            'senha' => 'nullable|string|min:6',
            'id_curso' => 'nullable|exists:courses,id_course',
            'tipo_estudante' => 'required|in:Interno,Externo',
        ]);

        $data = $request->all();
        if ($request->senha) {
            $data['senha'] = Hash::make($request->senha);
        } else {
            unset($data['senha']);
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Estudante atualizado com sucesso.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Estudante deletado com sucesso.');
    }
}
