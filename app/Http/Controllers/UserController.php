<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

 public function index()
    {
        $users = User::with('course')->get();
        $courses = Course::all();
        return view('users.index', compact('users', 'courses'));
    }


    
    public function create()
    {
        $courses = Course::with(['faculty', 'department'])->get();
        return view('auth.register', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'password'    => 'required|string|min:6|confirmed',
            'birth_date'  => 'nullable|date',
            'gender'      => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string|max:255',
             'course' => 'required|exists:courses,id_course',
            'level'       => 'required|integer|between:1,4',
            'period' => 'required|in:laboral,Pos-laboral', // validação do período
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'birth_date'  => $request->birth_date,
            'gender'      => $request->gender,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'id_course'   => $request->course,
            'level'       => $request->level,
            'period'      => $request->period, // salvar período
            'role'        => 'student',
        ]);

        return redirect()->route('login')->with('success', 'Conta criada com sucesso!');
    }
}
