<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link href="{{ asset('assets/css/reset-password.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="reset-container">

    <div class="icon-box">
        <i class="bi bi-shield-lock-fill"></i>
    </div>

    <h2 class="title">Nova Senha</h2>

    <p class="subtitle">
        Crie uma nova senha segura para sua conta.
    </p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email -->
        <div class="form-group">
            <i class="bi bi-envelope-fill"></i>

            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Digite seu email"
                required
                value="{{ old('email') }}"
            >
        </div>

        <!-- Senha -->
        <div class="form-group">
            <i class="bi bi-lock-fill"></i>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Nova senha"
                required
            >
        </div>

        <!-- Confirmar senha -->
        <div class="form-group">
            <i class="bi bi-shield-check"></i>

            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Confirmar senha"
                required
            >
        </div>

        <button type="submit" class="btn-reset">
            <i class="bi bi-arrow-repeat"></i>
            Redefinir Senha
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