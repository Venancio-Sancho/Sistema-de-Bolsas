@extends('main')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Bem-vindo, {{ $user->name }}</h3>
   
    {{-- Informações pessoais --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h6>👤 Dados do Estudante</h6>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Curso:</strong> {{ optional($user->course)->course_name ?? 'Não definido' }}</p>
            <p><strong>Nível:</strong> {{ $user->level ?? '-' }}</p>
            <p><strong>Período:</strong> {{ $user->period ?? '-' }}</p>
        </div>
    </div>

    {{-- Estado da candidatura --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h6>📄 Estado da Candidatura</h6>

            {{-- Exemplo --}}
            <span class="badge bg-warning">Ainda não submetida</span>
            {{-- depois pode ser: bg-success, bg-danger --}}
        </div>
    </div>

    {{-- Ações --}}
    <div class="row">
        <div class="col-md-6">
            <a href="#" class="card text-decoration-none shadow-sm">
                <div class="card-body">
                    <h6>📝 Submeter Candidatura</h6>
                    <p class="text-muted">Preencher formulário de candidatura</p>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="#" class="card text-decoration-none shadow-sm">
                <div class="card-body">
                    <h6>⚙️ Meu Perfil</h6>
                    <p class="text-muted">Atualizar dados pessoais</p>
                </div>
            </a>
        </div>
    </div>

</div>

@endsection
