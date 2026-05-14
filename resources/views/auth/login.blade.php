<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Login | Universidade Save</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    
    <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="login-card">

        <!-- HEADER -->
        <div class="header-section">

            <h2>
                Sistema Integrado de Candidatura de Bolsas da Universidade Save
            </h2>

            <div class="divider-container">
                <div class="divider-line"></div>

                <span class="sibolsave-text">
                    SIBOLSAVE
                </span>

                <div class="divider-line"></div>
            </div>

            <img src="{{ asset('assets/images/capela.AVIF') }}"
                alt="Logo"
                class="logo-img">

            <p class="instruction-text">
                Digite seu email e senha para acessar o sistema.
            </p>

        </div>

        <!-- ERROS -->
        @if ($errors->any() || session('error'))

            <div class="login-errors">

                @if (session('error'))
                    <div>
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <ul class="login-error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

            </div>

        @endif

        <!-- FORM -->
        <form action="{{ route('login.store') }}" method="POST">

            @csrf

            <!-- EMAIL -->
            <div class="form-group">

                <label class="form-label">
                    Email
                </label>

                <div class="input-wrapper">

                    <i class="uil uil-envelope-alt input-icon"></i>

                    <input type="email"
                        name="email"
                        class="form-control"
                        placeholder="Digite seu email"
                        required>

                </div>

            </div>

            <!-- SENHA -->
            <div class="form-group">

                <label class="form-label">
                    Senha
                </label>

                <div class="input-wrapper">

                    <i class="uil uil-lock-alt input-icon"></i>

                    <input type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Digite sua senha"
                        required>

                    <i class="uil uil-eye password-toggle"
                        id="togglePassword"></i>

                </div>

            </div>

            <!-- BOTÃO -->
            <button type="submit" class="btn-entrar">

                Entrar

                <i class="uil uil-arrow-right"></i>

            </button>

            <!-- REGISTAR -->
            <div class="register-footer">

                Ainda não tem conta?

                <a href="{{ route('register') }}">
                    Registar-se
                </a>

            </div>

            <!-- ESQUECEU SENHA -->
            <div class="forgot-password">

                <a href="{{ route('password.request') }}">
                    Esqueceu a senha?
                </a>

            </div>

        </form>

        <!-- COPYRIGHT -->
        <div class="bottom-copyright">

            © 2026 • Universidade Save

        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <!-- MOSTRAR SENHA -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {

            const type = password.getAttribute('type') === 'password'
                ? 'text'
                : 'password';

            password.setAttribute('type', type);

            this.classList.toggle('uil-eye');
            this.classList.toggle('uil-eye-slash');

        });
    </script>

</body>

</html>
