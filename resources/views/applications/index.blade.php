@extends('main')

@section('content')
<div class="container mt-4">

    {{-- TÍTULO E BOTÃO DE AÇÃO --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Candidaturas</h4>
        
        @if(auth()->user()->access_level != 1) 
            {{-- Estudante: Botão para adicionar candidatura --}}
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addApplicationModal">Adicionar Candidatura</button>
        @else
            {{-- Admin: Indica o modo de visualização --}}
            <h6 class="text-muted">Visualização Admin</h6>
        @endif
    </div>

    {{-- MENSAGENS DE FEEDBACK --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <hr>

    {{-- Definição dos campos de ficheiro (Usado tanto na tabela quanto nos Modais) --}}
    @php
        $fileFields = [
            'bilhete' => 'Bilhete de Identidade',
            'atestado_pobreza' => 'Atestado de Pobreza',
            'declaracao_bairro' => 'Declaração de Bairro',
            'declaracao_agregado' => 'Declaração de Agregado Familiar',
            'declaracao_rendimento' => 'Declaração de Rendimento',
            'aproveitamento' => 'Aproveitamento Académico'
        ];
    @endphp

    {{-- TABELA DE CANDIDATURAS --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr class="table-light">
                    @if(auth()->user()->access_level == 1)
                        <th>Estudante</th> {{-- Coluna extra para o Admin --}}
                    @endif
                    <th>Bolsa</th>
                    <th>Data</th>
                    <th>Estado</th> {{-- Traduzido de Status para Estado --}}
                    <th>Documentos</th>
                    <th class="text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                <tr>
                    {{-- Coluna Estudante (Apenas para Admin) --}}
                    @if(auth()->user()->access_level == 1)
                        <td>
                            <strong>{{ optional($application->user)->name ?? 'Usuário Removido' }}</strong>
                            <br><small class="text-muted">{{ optional($application->user)->email }}</small>
                        </td> 
                    @endif
                    
                    {{-- Coluna Bolsa --}}
                    <td>
                        {{ $application->scholarship->name }}
                        <br><small class="text-secondary">({{ $application->scholarship->status }})</small>
                    </td>
                    
                    {{-- Coluna Data --}}
                    <td>{{ \Carbon\Carbon::parse($application->application_date)->format('d/m/Y') }}</td>
                    
                    {{-- Coluna Estado (Traduzido e Colorido) --}}
                    @php
                        $statusText = match ($application->status) {
                            'approved' => 'Aprovada', 
                            'rejected' => 'Reprovada', 
                            default => 'Pendente',     
                        };
                        $statusClass = match ($application->status) {
                            'approved' => 'text-success fw-bold', 
                            'rejected' => 'text-danger fw-bold',  
                            default => 'text-warning',            
                        };
                    @endphp
                    <td class="{{ $statusClass }}">{{ $statusText }}</td>
                    
                    {{-- Coluna Documentos (Com lógica de Download para Admin) --}}
                    <td>
                        @foreach($fileFields as $field => $label)
                            @if($application->{$field . '_path'})
                                @if(auth()->user()->access_level == 1)
                                    {{-- Se for Admin: Link para Download --}}
                                    <a href="{{ route('applications.download_document', ['id_application' => $application->id_application, 'file_field' => $field]) }}" class="text-primary" title="Baixar {{ $label }}">
                                        {{ $label }}
                                    </a><br>
                                @else
                                    {{-- Se não for Admin: Link para visualização (abre no navegador) --}}
                                    <a href="{{ asset('storage/'.$application->{$field . '_path'}) }}" target="_blank" class="text-secondary">
                                        {{ $label }}
                                    </a><br>
                                @endif
                            @endif
                        @endforeach
                    </td>
                    
                    {{-- Coluna Ação --}}
                    <td class="text-center">
                        
                        {{-- AÇÕES EXCLUSIVAS DO ADMIN (Aprovar/Reprovar) --}}
                        @if(auth()->user()->access_level == 1) 
                            <div class="d-grid gap-1 mb-2">
                                
                                {{-- Botão Aprovar --}}
                                @if($application->status !== 'approved')
                                    <form action="{{ route('applications.change_status', $application->id_application) }}" method="POST" style="display:block;">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn btn-sm btn-success" onclick="return confirm('Aprovar esta candidatura?')" style="width: 100%;">Aprovar</button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-outline-success" disabled style="width: 100%;">Aprovada</button>
                                @endif
                                
                                {{-- Botão Reprovar --}}
                                @if($application->status !== 'rejected')
                                    <form action="{{ route('applications.change_status', $application->id_application) }}" method="POST" style="display:block;">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Reprovar esta candidatura?')" style="width: 100%;">Reprovar</button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-outline-danger" disabled style="width: 100%;">Reprovada</button>
                                @endif
                            </div>
                        @endif
                        
                        {{-- AÇÕES DE EDIÇÃO E EXCLUSÃO (Para Dono ou Admin) --}}
                        @if(auth()->user()->id === $application->id_user || auth()->user()->access_level == 1)
                            <div class="mt-2 d-flex justify-content-center gap-1">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editApplicationModal{{ $application->id_application }}">Editar</button>
                                
                                <form action="{{ route('applications.destroy', $application->id_application) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja apagar esta candidatura?')" title="Apagar Candidatura">Apagar</button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>

                {{-- MODAL DE EDIÇÃO (Abrirá para cada Candidatura) --}}
                <div class="modal fade" id="editApplicationModal{{ $application->id_application }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('applications.update', $application->id_application) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Candidatura</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Bolsa</label>
                                        <select name="id_scholarship" class="form-control" required>
                                            @foreach($scholarships as $s)
                                                <option value="{{ $s->id }}" 
                                                    {{ $s->id == $application->id_scholarship ? 'selected' : '' }} 
                                                    {{ (mb_strtolower(str_replace(' ', '', $s->status)) === 'indisponivel') ? 'disabled' : '' }}>
                                                    {{ $s->name }} {{ (mb_strtolower(str_replace(' ', '', $s->status)) === 'indisponivel') ? '(Indisponível)' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Data de candidatura</label>
                                        <input type="date" name="application_date" class="form-control" value="{{ $application->application_date }}" required>
                                    </div>
                                    
                                    <hr>
                                    <p class="text-muted"><small>Enviar um novo ficheiro **substitui** o existente. Formatos: pdf/jpg/png. Máx 2MB.</small></p>

                                    {{-- Campos para upload de documentos --}}
                                    @foreach($fileFields as $field => $label)
                                        <div class="mb-2">
                                            <label class="form-label">{{ $label }} 
                                                @if($application->{$field . '_path'})
                                                    (<a href="{{ asset('storage/'.$application->{$field . '_path'}) }}" target="_blank">Ver Atual</a>)
                                                @endif
                                            </label>
                                            <input type="file" name="{{ $field }}" class="form-control">
                                        </div>
                                    @endforeach

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="submit">Salvar Alterações</button>
                                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="{{ auth()->user()->access_level == 1 ? '6' : '5' }}" class="text-center">Nenhuma candidatura encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL DE ADICIONAR (Apenas para Estudante) --}}
    @if(auth()->user()->access_level != 1) 
    <div class="modal fade" id="addApplicationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" id="addApplicationForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Submeter Nova Candidatura</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <h6 class="text-primary mb-3">Informação do Candidato</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estudante</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Curso (Snapshot)</label>
                                <input type="text" class="form-control" value="{{ optional(auth()->user()->course)->course_name ?? 'N/A' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ano/Nível</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->level }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Período</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->period }}" readonly>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label">Bolsa <span class="text-danger">*</span></label>
                            <select name="id_scholarship" id="scholarshipSelect" class="form-control" required>
                                <option value="">-- Selecionar Bolsa --</option>
                                @foreach($scholarships as $s)
                                    <option value="{{ $s->id }}" data-status="{{ $s->status }}" 
                                        {{ (mb_strtolower(str_replace(' ', '', $s->status)) === 'indisponivel') ? 'disabled' : '' }}>
                                        {{ $s->name }} {{ (mb_strtolower(str_replace(' ', '', $s->status)) === 'indisponivel') ? '(Indisponível)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Data de candidatura <span class="text-danger">*</span></label>
                            <input type="date" name="application_date" class="form-control" required>
                        </div>

                        <hr>
                        <h6 class="text-primary mb-3">Documentos Necessários (PDF, JPG, PNG - Máx 2MB)</h6>

                        {{-- Campos de ficheiro para adicionar --}}
                        @foreach($fileFields as $field => $label)
                            <div class="mb-2">
                                <label class="form-label">{{ $label }} <span class="text-danger">*</span></label>
                                <input type="file" name="{{ $field }}" class="form-control" required>
                            </div>
                        @endforeach
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submeter Candidatura</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lógica de validação do lado do cliente para Bolsas Indisponíveis
    const scholarshipSelect = document.getElementById('scholarshipSelect');
    const addForm = document.getElementById('addApplicationForm');

    if (scholarshipSelect && addForm) {
        addForm.addEventListener('submit', function(e) {
            const opt = scholarshipSelect.options[scholarshipSelect.selectedIndex];
            if (!opt || opt.value === "") {
                e.preventDefault();
                alert('Por favor, selecione uma bolsa válida.');
                return false;
            }
            const status = opt.getAttribute('data-status') || '';
            if (status && status.toLowerCase().replace(/\s/g,'') === 'indisponivel') {
                e.preventDefault();
                alert('Esta bolsa está indisponível. Escolha outra.');
                return false;
            }
        });
    }
});
</script>
@endpush