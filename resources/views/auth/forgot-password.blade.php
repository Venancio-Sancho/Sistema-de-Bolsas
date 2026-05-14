<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('assets/css/forgot-password.css') }}" rel="stylesheet" type="text/css" />
   
</head>
<body>

    <div class="reset-card">

        <div class="logo-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <h2 class="title">Recuperar Senha</h2>

        <p class="subtitle">
            Informe o seu email para receber o link de redefinição da senha.
        </p>

        @if(session('status'))
            <div class="success-message">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="input-wrapper">
                <span class="input-group-text">
                    <i class="bi bi-envelope-fill"></i>
                </span>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Digite o seu email"
                    required
                >
            </div>

            <button type="submit" class="btn-reset">
                <i class="bi bi-send-fill"></i>
                Enviar 
            </button>
        </form>

        <div class="back-login">
            <a href="{{ route('login') }}">
                <i class="bi bi-arrow-left"></i>
                Voltar ao Login
            </a>
        </div>

    </div>

</body>
</html>