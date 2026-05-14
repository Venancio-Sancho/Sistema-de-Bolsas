<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Mostrar o formulário de registo
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Registar novo candidato (cria em User e Student)
     */
    
    public function register(Request $request)
    {
        $request->validate([
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:students,email|unique:users,email',
            'password'        => 'required|string|min:6|confirmed',
            'birth_date'      => 'required|date',
            'gender'          => 'required|in:Male,Female',
            'student_type'    => 'required|in:internal,external',
        ]);

        // 1️⃣ Criar estudante
        $student = Student::create([
            'nome_completo'   => $request->full_name,
            'email'           => $request->email,
            'senha'           => Hash::make($request->password),
            'tipo_estudante'  => $request->student_type,
            'data_nascimento' => $request->birth_date,
            'sexo'            => $request->gender,
            'telefone'        => $request->phone ?? null,
            'endereco'        => $request->address ?? null,
            'data_registo'    => now(),
        ]);

        // 2️⃣ Criar utilizador na tabela users
        $user = User::create([
            'name'     => $request->full_name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'student',
        ]);

        // 3️⃣ Autenticar o utilizador
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }

    /**
     * Mostrar o formulário de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Efetuar login
     */
 
public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    $email = $request->email;
    $password = $request->password;

    $user = User::where('email', $email)->first();

    // ❌ Email não existe
    if (!$user) {
        return back()->withErrors([
            'email' => 'O email está errado.'
        ])->withInput();
    }

    // ❌ Senha errada
    if (!Hash::check($password, $user->password)) {
        return back()->withErrors([
            'password' => 'A senha está errada.'
        ])->withInput();
    }

    // ✅ Login correto
    Auth::login($user);

    if ($user->role === 'admin') {
        return redirect()->route('admin.index');
    }

    return redirect()->route('student.index');
}
   

    /**
     * Efetuar logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
