@extends('main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet" type="text/css" />
<div class="container-fluid pt-2 pb-5 px-4 admin-dashboard">

    @php
          \Carbon\Carbon::setLocale('pt');
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-secondary">Painel do Administrador</h3>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
            {{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
        </span>
    </div>
     
    {{-- Cards de resumo --}}
 <div class="row g-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase small fw-bold">Estudantes</h6>
                    <h3 class="mb-0 fw-bold">{{ \App\Models\User::where('role','student')->count() }}</h3>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded">
                    <i class="bi bi-people text-primary fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-warning border-4">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase small fw-bold">Candidaturas</h6>
                    {{-- Ajuste 'Candidatura' para o nome correto do seu Model --}}
                    <h3 class="mb-0 fw-bold">{{ \App\Models\Application::count() }}</h3>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded">
                    <i class="bi bi-file-earmark-text text-warning fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-success border-4">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase small fw-bold">Bolsas Ativas</h6>
                    {{-- Ajuste 'Scholarship' para o nome correto do seu Model e o status se necessário --}}
                    <h3 class="mb-0 fw-bold">{{ \App\Models\Scholarship::where('status', 'Disponível')->count() }}</h3>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded">
                    <i class="bi bi-mortarboard text-success fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-info border-4">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase small fw-bold">Admins</h6>
                    <h3 class="mb-0 fw-bold">{{ \App\Models\User::where('role','admin')->count() }}</h3>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded">
                    <i class="bi bi-shield-check text-info fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

    <h5 class="mt-5 mb-3 fw-bold text-secondary">Ações Rápidas</h5>

    {{-- Ações rápidas --}}
   <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('applications.index') }}" class="card text-decoration-none shadow-sm h-100 action-card custom-blue-border">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="fa fa-folder-open fs-1 text-primary"></i> 
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Gerir Candidaturas</h5>
                    <p class="small text-muted mb-0">Avaliar e aprovar novos processos de entrada.</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('scholarships.index') }}" class="card text-decoration-none shadow-sm h-100 action-card custom-blue-border">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="fa fa-graduation-cap fs-1 text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Gerir Bolsas</h5>
                    <p class="small text-muted mb-0">Configurar critérios e prazos de bolsas individuais.</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('users.index') }}" class="card text-decoration-none shadow-sm h-100 action-card custom-blue-border">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="fa fa-user fs-1 text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Estudantes</h5>
                    <p class="small text-muted mb-0">Controle de acessos e perfis de estudantes.</p>
                </div>
            </a>
        </div>
    </div>
</div>





@endsection