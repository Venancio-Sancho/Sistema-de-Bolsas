@extends('main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="{{ asset('assets/css/student.css') }}" rel="stylesheet" type="text/css" />

<div class="container-fluid pt-2 pb-5 px-4 student-dashboard">


     @php
     
        \Carbon\Carbon::setLocale('pt');

    $candidatura = $user->applications()->latest('id_application')->first();
    
    // Configura????es reais para o Banner
    $statusTexto = $candidatura ? match ($candidatura->status) {
        'approved' => 'Aprovado',
        'rejected' => 'Reprovado',
        'pending' => 'Pendente',
        default => 'Pendente',
    } : 'Nenhum Registro';
    $statusDescricao = $candidatura 
        ? ($candidatura->observations ?? 'Seu processo está sendo avaliado pela comissão acadêmica.') 
        : 'Você ainda não possui um processo de candidatura ativo no sistema.';
    
    // Cores dinâmicas para o badge
    $badgeClass = $candidatura ? 'bg-white text-primary' : 'bg-danger text-white';
    $statusLabel = $candidatura ? 'PROCESSO ATIVO' : 'PENDENTE';
@endphp
    <div class="row mb-5 align-items-end">
        <div class="col">
            <h5 class="text-primary fw-bold mb-1">Bem Vindo</h5>
            <h2 class="fw-extrabold text-dark m-0"> {{ explode(' ', $user->name)[0] }}!</h2>
        </div>
        <div class="col-auto">
            <div class="bg-white border rounded-pill px-4 py-2 shadow-sm d-flex align-items-center">
                <div class="bg-primary rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                <span class="small fw-bold text-secondary">{{ now()->translatedFormat('l, d \d\e F \d\e Y') }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Banner com Dados Reais da Candidatura --}}
            <div class="status-banner p-4 mb-4 shadow-lg">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <span class="badge {{ $candidatura ? 'bg-white text-primary' : 'bg-warning text-dark' }} mb-2 px-3 py-2 rounded-pill fw-bold">
                            {{ $candidatura ? 'PROCESSO ATIVO' : 'PENDENTE' }}
                        </span>
                        <h3 class="fw-bold">Estado da Candidatura</h3>
                        {{-- Descrição Real vinda das observações ou padrão --}}
                        <p class="opacity-75 mb-4">{{ $statusDescricao }}</p>
                        
                        <div class="d-flex align-items-center">
                            {{-- Status Real do Banco --}}
                            <h2 class="fw-extrabold m-0 me-3">{{ ucfirst($statusTexto) }}</h2>
                            <i class="fa fa-arrow-right opacity-50"></i>
                        </div>
                    </div>
                    <div class="col-md-5 d-none d-md-block text-center">
                        <i class="fa {{ $candidatura && $candidatura->status == 'Aprovado' ? 'fa-check-double' : 'fa-file-signature' }}" 
                           style="font-size: 6rem; opacity: 0.2;"></i>
                    </div>
                </div>
            </div>

            {{-- Informações da Conta (Dados Reais do Usuário) --}}
            <div class="premium-card shadow-sm p-4">
                <h5 class="fw-bold text-dark mb-4">Informações da Conta</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-box d-flex align-items-center">
                            <div class="icon-circle me-3"><i class="fa fa-envelope"></i></div>
                            <div>
                                <div class="stat-label">E-mail</div>
                                <div class="fw-bold text-dark text-break">{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box d-flex align-items-center">
                            <div class="icon-circle me-3"><i class="fa fa-graduation-cap"></i></div>
                            <div>
                                <div class="stat-label">Curso</div>
                                <div class="fw-bold text-dark">{{ $user->course->course_name ?? 'Não Definido' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box d-flex align-items-center">
                            <div class="icon-circle me-3"><i class="fa fa-layer-group"></i></div>
                            <div>
                                <div class="stat-label">Nível</div>
                                <div class="fw-bold text-dark">{{ $user->level ?? '-' }}º Ano</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box d-flex align-items-center">
                            <div class="icon-circle me-3"><i class="fa fa-moon"></i></div>
                            <div>
                                <div class="stat-label">Período</div>
                                <div class="fw-bold text-dark">{{ $user->period ?? 'Não Definido' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 services-col">
            <div class="mb-4">
                <h5 class="fw-bold text-dark mb-3">Serviços</h5>
                
                {{-- Link Dinâmico: Se já tem candidatura, pode ocultar ou mudar para "Ver Minha Candidatura" --}}
                <a href="{{ route('applications.index') }}" class="quick-action shadow-sm mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle p-3 rounded-4 me-3 text-primary">
                            <i class="fa fa-plus-circle fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-0">Nova Candidatura</h6>
                            <small class="text-muted">Submeter novos documentos</small>
                        </div>
                        <i class="fa fa-chevron-right text-light"></i>
                    </div>
                </a>

                <a href="#" class="quick-action shadow-sm mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-subtle p-3 rounded-4 me-3 text-info">
                            <i class="fa fa-user-gear fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-0">Gerenciar Perfil</h6>
                            <small class="text-muted">Editar dados pessoais</small>
                        </div>
                        <i class="fa fa-chevron-right text-light"></i>
                    </div>
                </a>
            </div>

            <div class="premium-card p-4 bg-dark text-white shadow-lg support-card">
                <h6 class="fw-bold mb-2">Suporte ao Aluno</h6>
                <p class="small opacity-75 mb-4">Tem dúvidas sobre o processo de seleção ou documentação?</p>
                <a href="#" class="btn btn-outline-light btn-sm rounded-pill px-4">Centro de Ajuda</a>
            </div>
        </div>
    </div>
</div>
@endsection
