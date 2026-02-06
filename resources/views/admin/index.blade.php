@extends('main')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Painel do Administrador</h3>

    {{-- Cards de resumo --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6>Total de Estudantes</h6>
                    <h3>{{ \App\Models\User::where('role','student')->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6>Candidaturas</h6>
                    <h3>--</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6>Bolsas Ativas</h6>
                    <h3>--</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6>Admins</h6>
                    <h3>{{ \App\Models\User::where('role','admin')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Ações rápidas --}}
    <div class="row mt-4">
        <div class="col-md-4">
            <a href="#" class="card text-decoration-none shadow-sm">
                <div class="card-body">
                    <h6>📄 Gerir Candidaturas</h6>
                    <p class="text-muted">Avaliar e aprovar candidaturas</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="#" class="card text-decoration-none shadow-sm">
                <div class="card-body">
                    <h6>🎓 Gerir Bolsas</h6>
                    <p class="text-muted">Criar e editar bolsas</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="#" class="card text-decoration-none shadow-sm">
                <div class="card-body">
                    <h6>👥 Utilizadores</h6>
                    <p class="text-muted">Administrar estudantes</p>
                </div>
            </a>
        </div>
    </div>

</div>

@endsection
