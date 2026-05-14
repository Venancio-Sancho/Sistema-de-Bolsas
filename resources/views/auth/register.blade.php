<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8" />
    <title>Registar | Universidade Save</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    
    <link href="{{ asset('assets/css/register.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="register-card">

        <!-- HEADER -->
        <div class="header-section">

            <h4>Registar-se</h4>

            <p class="instruction-text">
                Preencha os seus dados para aceder ao SIBOLSAVE
            </p>

        </div>

        <!-- FORM -->
        <div class="form-container">

            <!-- ERROS -->
            @if ($errors->any())

                <div class="alert alert-danger mb-4">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('register.store') }}" method="POST">

                @csrf

                <div class="row">

                    <!-- NOME -->
                    <div class="col-md-12">

                        <label class="form-label">
                            Nome Completo
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-user input-icon"></i>

                            <input type="text"
                                name="name"
                                class="form-control"
                                placeholder="Digite o seu nome completo"
                                required>

                        </div>

                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Email
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-envelope-alt input-icon"></i>

                            <input type="email"
                                name="email"
                                class="form-control"
                                placeholder="exemplo@save.ac.mz"
                                required>

                        </div>

                    </div>

                    <!-- TELEFONE -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Telefone
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-phone input-icon"></i>

                            <input type="text"
                                name="phone"
                                class="form-control"
                                placeholder="+258..."
                                required>

                        </div>

                    </div>

                    <!-- SENHA -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Senha
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-lock-alt input-icon"></i>

                            <input type="password"
                                name="password"
                                class="form-control"
                                placeholder="Digite sua senha"
                                required>

                        </div>

                    </div>

                    <!-- CONFIRMAR -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Confirmar Senha
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-check-circle input-icon"></i>

                            <input type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Confirme a senha"
                                required>

                        </div>

                    </div>

                    <!-- NASCIMENTO -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Data de Nascimento
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-calendar-alt input-icon"></i>

                            <input type="date"
                                name="birth_date"
                                class="form-control">

                        </div>

                    </div>

                    <!-- GENERO -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Género
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-venus-mars input-icon"></i>

                            <select name="gender"
                                class="form-control">

                                <option value="">
                                    Selecionar género
                                </option>

                                <option value="Masculino">
                                    Masculino
                                </option>

                                <option value="Feminino">
                                    Feminino
                                </option>

                            </select>

                        </div>

                    </div>

                    <!-- CURSO -->
                    <div class="col-md-12">

                        <label class="form-label">
                            Curso de Ingresso
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-book-alt input-icon"></i>

                            <select name="course"
                                id="course"
                                class="form-control"
                                required>

                                <option value="">
                                    -- Selecione o seu curso --
                                </option>

                                @foreach($courses as $course)

                                    <option value="{{ $course->id_course }}"
                                        data-faculty="{{ $course->faculty->faculty_name ?? '' }}"
                                        data-department="{{ $course->department->department_name ?? '' }}">

                                        {{ $course->course_name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <!-- FACULDADE -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Faculdade
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-building input-icon"></i>

                            <input type="text"
                                id="faculty"
                                class="form-control"
                                placeholder="Faculdade"
                                readonly>

                        </div>

                    </div>

                    <!-- DEPARTAMENTO -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Departamento
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-sitemap input-icon"></i>

                            <input type="text"
                                id="department"
                                class="form-control"
                                placeholder="Departamento"
                                readonly>

                        </div>

                    </div>

                    <!-- NIVEL -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Nível / Ano
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-graduation-cap input-icon"></i>

                            <select name="level"
                                class="form-control"
                                required>

                                <option value="">
                                    Selecionar Ano
                                </option>

                                <option value="1">
                                    1º Ano
                                </option>

                                <option value="2">
                                    2º Ano
                                </option>

                                <option value="3">
                                    3º Ano
                                </option>

                                <option value="4">
                                    4º Ano
                                </option>

                            </select>

                        </div>

                    </div>

                    <!-- REGIME -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Regime
                        </label>

                        <div class="input-wrapper">

                            <i class="uil uil-clock input-icon"></i>

                            <select name="period"
                                class="form-control"
                                required>

                                <option value="">
                                    Selecionar período
                                </option>

                                <option value="laboral">
                                    Laboral
                                </option>

                                <option value="Pos-Laboral">
                                    Pós-Laboral
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <!-- BOTÃO -->
                <button type="submit" class="btn-registar">

                    Registar
                    <i class="uil uil-arrow-right"></i>

                </button>

                <!-- LOGIN -->
                <div class="login-footer">

                    Já tem uma conta?

                    <a href="{{ route('login') }}">
                        Fazer Login
                    </a>

                </div>

            </form>

            <!-- COPYRIGHT -->
            <div class="copyright">

                © 2026 • Universidade Save

            </div>

        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <script>
        document.getElementById('course').addEventListener('change', function() {

            let selected = this.options[this.selectedIndex];

            document.getElementById('faculty').value =
                selected.getAttribute('data-faculty') || '';

            document.getElementById('department').value =
                selected.getAttribute('data-department') || '';

        });
    </script>

</body>
</html>