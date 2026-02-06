@extends('main')

@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SIBOLSAVE</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <h4 class="page-title">Bem-vindo, {{ Auth::user()->name }}!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-file-document-edit widget-icon bg-primary text-white"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Candidaturas Ativas">Candidaturas</h5>
                    <h3 class="my-3">45</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 12%</span>
                        <span class="text-nowrap">Desde o último mês</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-school widget-icon bg-success text-white"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Bolsas Disponíveis">Bolsas Abertas</h5>
                    <h3 class="my-3">08</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-danger me-2"><i class="mdi mdi-clock-outline"></i> 2 dias</span>
                        <span class="text-nowrap">Para o fecho</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-check-decagram widget-icon bg-info text-white"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Aprovados">Aprovados</h5>
                    <h3 class="my-3">12</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><i class="mdi mdi-trending-up"></i> +3</span>
                        <span class="text-nowrap">Esta semana</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Minhas Candidaturas Recentes</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tipo de Bolsa</th>
                                    <th>Data de Submissão</th>
                                    <th>Estado</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bolsa Completa - Internato</td>
                                    <td>05/02/2026</td>
                                    <td><span class="badge bg-warning">Em Análise</span></td>
                                    <td><a href="#" class="btn btn-sm btn-light">Ver Detalhes</a></td>
                                </tr>
                                <tr>
                                    <td>Bolsa de Redução de Propinas</td>
                                    <td>20/01/2026</td>
                                    <td><span class="badge bg-success">Aprovada</span></td>
                                    <td><a href="#" class="btn btn-sm btn-light">Ver Detalhes</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> </div> </div> </div> </div>
</div>
@endsection
