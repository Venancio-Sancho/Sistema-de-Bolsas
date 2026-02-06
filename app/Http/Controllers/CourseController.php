<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('department.faculty')->get();
        $departments = Department::with('faculty')->get();
        return view('courses.index', compact('courses', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id_department',
            'description' => 'nullable|string',
        ]);

        $department = Department::findOrFail($request->department_id);

        Course::create([
            'course_name'   => $request->course_name,
            'department_id' => $request->department_id,
            'faculty_id'    => $department->faculty_id,
            'description'   => $request->description,
        ]);

        return redirect()->route('courses.index')->with('success', 'Curso criado com sucesso.');
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id_department',
            'description' => 'nullable|string',
        ]);

        $department = Department::findOrFail($request->department_id);

        $course->update([
            'course_name'   => $request->course_name,
            'department_id' => $request->department_id,
            'faculty_id'    => $department->faculty_id,
            'description'   => $request->description,
        ]);

        return redirect()->route('courses.index')->with('success', 'Curso atualizado com sucesso.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Curso deletado com sucesso.');
    }
}
