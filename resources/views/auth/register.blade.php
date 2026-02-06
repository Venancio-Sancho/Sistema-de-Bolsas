<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8" />
    <title>Registar | Universidade Save</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de Gestão de Bolsas" name="description" />
    <meta content="Universidade Save" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
</head>

<body class="loading authentication-bg">

<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                        <a href="{{ route('register') }}">
                            <span><img src="{{ asset('assets/images/logo.png') }}" alt="Logo" height="22"></span>
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <!-- Título e descrição -->
                        <div class="text-center w-75 m-auto mb-3">
                            <h4 class="text-dark-50 fw-bold">Criar Conta</h4>
                            <p class="text-muted mb-3">Preencha o formulário abaixo para se registar.</p>
                        </div>

                        <!-- Erros -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Formulário -->
                        <form action="{{ route('register.store') }}" method="POST">
                            @csrf

                            <!-- Nome -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="uil uil-user"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Nome completo" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="uil uil-envelope-alt"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>

                            <!-- Senha e Confirmar -->
                            <div class="row">
                                <div class="col-md-6 mb-3 input-group">
                                    <span class="input-group-text"><i class="uil uil-lock-alt"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Senha" required>
                                </div>
                                <div class="col-md-6 mb-3 input-group">
                                    <span class="input-group-text"><i class="uil uil-lock-alt"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar Senha" required>
                                </div>
                            </div>

                            <!-- Data de Nascimento e Gênero -->
                            <div class="row">
                                <div class="col-md-6 mb-3 input-group">
                                    <span class="input-group-text"><i class="uil uil-calendar-alt"></i></span>
                                    <input type="date" name="birth_date" class="form-control" placeholder="Data de nascimento">
                                </div>
                                <div class="col-md-6 mb-3 input-group">
                                    <span class="input-group-text"><i class="uil uil-venus-mars"></i></span>
                                    <select name="gender" class="form-control">
                                        <option value="">-- Selecionar Gênero --</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Feminino">Feminino</option>
                                        <option value="Outro">Outro</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Telefone -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="uil uil-phone"></i></span>
                                <input type="text" name="phone" class="form-control" placeholder="Telefone">
                            </div>

                            <!-- Endereço -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="uil uil-location-point"></i></span>
                                <input type="text" name="address" class="form-control" placeholder="Endereço">
                            </div>

                            <!-- Curso -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="uil uil-book-alt"></i></span>
                                <select name="course" id="course" class="form-control" required>
                                    <option value="">-- Selecionar Curso --</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id_course }}"
                                            data-faculty="{{ $course->faculty->faculty_name ?? '' }}"
                                            data-department="{{ $course->department->department_name ?? '' }}">
                                            {{ $course->course_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Faculdade -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="uil uil-building"></i></span>
                                <input type="text" id="faculty" class="form-control" placeholder="Faculdade" readonly>
                            </div>

                            <!-- Departamento -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="uil uil-sitemap"></i></span>
                                <input type="text" id="department" class="form-control" placeholder="Departamento" readonly>
                            </div>

                            <!-- Nível -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="uil uil-graduation-cap"></i></span>
                                <select name="level" class="form-control" required>
                                    <option value="">-- Selecionar Nível --</option>
                                    <option value="1">1º Ano</option>
                                    <option value="2">2º Ano</option>
                                    <option value="3">3º Ano</option>
                                    <option value="4">4º Ano</option>
                                </select>
                            </div>

                            <!-- Período -->
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="uil uil-clock"></i></span>
                                <select name="period" class="form-control" required>
                                    <option value="">-- Selecionar Período --</option>
                                    <option value="Semilaboral">laboral</option>
                                </select>
                            </div>

                            <div class="d-grid text-center mb-3">
                                <button class="btn btn-primary" type="submit">Registar</button>
                            </div>
                        </form>

                        <!-- Link de login dentro do card -->
                        <div class="mt-2 text-center">
                            <p class="text-muted mb-1">Já tem uma conta?</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary fw-bold">Entrar</a>
                        </div>

                        <!-- Rodapé dentro do card -->
                        <div class="mt-3 text-center text-muted">
                            2025 © Universidade Save
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<script>
    // Atualiza automaticamente faculdade e departamento ao escolher o curso
    document.getElementById('course').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        document.getElementById('faculty').value = selected.getAttribute('data-faculty') || '';
        document.getElementById('department').value = selected.getAttribute('data-department') || '';
    });
</script>
</body>
</html>
