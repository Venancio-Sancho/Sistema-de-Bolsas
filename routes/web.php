<?php


use App\Http\Controllers\FacultyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Student\StudentDashboardController;
use Illuminate\Support\Facades\Route;

// Página inicial redireciona para login
Route::middleware(['auth'])->group(function () {

 Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/index', [AdminDashboardController::class, 'index'])
        ->name('admin.index');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/index', [StudentDashboardController::class, 'index'])
        ->name('student.index');
});
    
// Autenticação

// 1. ROTAS PÚBLICAS (Acessíveis sem login)
Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // FACULDADES
    Route::prefix('faculties')->name('faculties.')->group(function () {
        Route::get('/', [FacultyController::class, 'index'])->name('index');
        Route::get('/create', [FacultyController::class, 'create'])->name('create');
        Route::post('/', [FacultyController::class, 'store'])->name('store');
        Route::get('/{faculty}/edit', [FacultyController::class, 'edit'])->name('edit');
        Route::put('/{faculty}', [FacultyController::class, 'update'])->name('update');
        Route::delete('/{faculty}', [FacultyController::class, 'destroy'])->name('destroy');
    });

    // DEPARTAMENTOS
      Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::post('/', [DepartmentController::class, 'store'])->name('store');
        Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
        Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('destroy');
    });


    // CURSOS
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

 
    // BOLSAS
    Route::get('/scholarships', [ScholarshipController::class, 'index'])->name('scholarships.index');
    Route::get('/scholarships/create', [ScholarshipController::class, 'create'])->name('scholarships.create');
    Route::post('/scholarships', [ScholarshipController::class, 'store'])->name('scholarships.store');
    Route::get('/scholarships/{id}/edit', [ScholarshipController::class, 'edit'])->name('scholarships.edit');
    Route::put('/scholarships/{id}', [ScholarshipController::class, 'update'])->name('scholarships.update');
    Route::delete('/scholarships/{id}', [ScholarshipController::class, 'destroy'])->name('scholarships.destroy');

    // CANDIDATURAS
    Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::put('applications/{id_application}', [ApplicationController::class, 'update'])->name('applications.update');
    Route::delete('applications/{id_application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    Route::put('applications/{id_application}/status', [ApplicationController::class, 'changeStatus'])->name('applications.change_status');
    Route::get('applications/{id_application}/download/{file_field}', [ApplicationController::class, 'downloadDocument'])->name('applications.download_document');
   
    // USUÁRIOS
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/{student}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // RESULTADOS
    Route::resource('results', ResultController::class);

    // AJAX
    Route::get('/departments/{id}/faculty', [CourseController::class, 'getFacultyByDepartment']);
}); // <<< Aqui fecha o group auth corretamente
