@extends('main')

@section('content')
<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">
<h4>Candidaturas</h4>

@if(auth()->user()->access_level != 1)
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addApplicationModal">
Adicionar Candidatura
</button>
@else
@can('excluir')
 <a href="{{ route('reports.pdf') }}" class="btn btn-danger mt-3">
    📥 Exportar PDF
    </a>
@endcan
@endif

</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach($errors->all() as $e)
<li>{{ $e }}</li>
@endforeach
</ul>
</div>
@endif

<hr>

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

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead>
<tr class="table-light">
@if(auth()->user()->access_level == 1)
<th>Estudante</th>
@endif
<th>Bolsa</th>
<th>Data</th>
<th>Estado</th>
<th>Documentos</th>
<th class="text-center">Ação</th>
</tr>
</thead>
<tbody>
@forelse($applications as $application)
<tr>
@if(auth()->user()->access_level == 1)
<td>
<strong>{{ optional($application->user)->name }}</strong><br>
<small class="text-muted">{{ optional($application->user)->email }}</small>
</td>
@endif
<td>
{{ $application->scholarship->name }}<br>
<small class="text-secondary">({{ $application->scholarship->status }})</small>
</td>
<td>{{ \Carbon\Carbon::parse($application->application_date)->format('d/m/Y') }}</td>
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
<td>
@foreach($fileFields as $field => $label)
@if($application->{$field . '_path'})
@if(auth()->user()->access_level == 1)
<a href="{{ route('applications.download_document',['id_application'=>$application->id_application,'file_field'=>$field]) }}" class="text-primary">{{ $label }}</a><br>
@else
<a href="{{ asset('storage/'.$application->{$field . '_path'}) }}" target="_blank">{{ $label }}</a><br>
@endif
@endif
@endforeach
</td>
<td class="text-center">
@if(auth()->user()->access_level == 1)
<div class="d-grid gap-1">
@if($application->status !== 'approved')
<button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $application->id_application }}">Aprovar</button>
@endif
@if($application->status !== 'rejected')
<button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $application->id_application }}">Reprovar</button>
@endif
</div>
@endif
@if(auth()->user()->id === $application->id_user || auth()->user()->access_level == 1)
<div class="mt-2 d-flex justify-content-center gap-1">
@if(auth()->user()->access_level != 1 && $application->status === 'pending')
<button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editApplicationModal{{ $application->id_application }}">Editar</button>
@endif
<button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $application->id_application }}">Apagar</button>
</div>
@endif
</td>
</tr>

<div class="modal fade" id="editApplicationModal{{ $application->id_application }}" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-warning text-dark">
<h5 class="modal-title">Editar Candidatura</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<form method="POST" action="{{ route('applications.update', $application->id_application) }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="modal-body">
<div class="row g-3">
<div class="col-md-6">
<label class="form-label">Bolsa</label>
<select name="id_scholarship" class="form-select" required>
@foreach($scholarships as $scholarship)
<option value="{{ $scholarship->id }}" {{ $application->id_scholarship == $scholarship->id ? 'selected' : '' }}>
{{ $scholarship->name }} ({{ $scholarship->status }})
</option>
@endforeach
</select>
</div>
<div class="col-md-6">
<label class="form-label">Data da candidatura</label>
<input type="date" name="application_date" class="form-control" value="{{ $application->application_date }}" required>
</div>
@foreach($fileFields as $field => $label)
<div class="col-md-6">
<label class="form-label">{{ $label }}</label>
<input type="file" name="{{ $field }}" class="form-control" accept=".pdf,.jpg,.png">
<small class="text-muted">Opcional ao editar.</small>
</div>
@endforeach
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-warning">Guardar alterações</button>
</div>
</form>
</div>
</div>
</div>

<div class="modal fade" id="approveModal{{ $application->id_application }}">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-success text-white">
<h5 class="modal-title">Aprovar Candidatura</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">Tem certeza que deseja aprovar esta candidatura?</div>
<div class="modal-footer">
<form method="POST" action="{{ route('applications.change_status',$application->id_application) }}">
@csrf
@method('PUT')
<input type="hidden" name="status" value="approved">
<button class="btn btn-success">Sim Aprovar</button>
</form>
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
</div>
</div>
</div>
</div>

<div class="modal fade" id="rejectModal{{ $application->id_application }}">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-danger text-white">
<h5 class="modal-title">Reprovar Candidatura</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">Tem certeza que deseja reprovar esta candidatura?</div>
<div class="modal-footer">
<form method="POST" action="{{ route('applications.change_status',$application->id_application) }}">
@csrf
@method('PUT')
<input type="hidden" name="status" value="rejected">
<button class="btn btn-danger">Sim Reprovar</button>
</form>
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
</div>
</div>
</div>
</div>

<div class="modal fade" id="deleteModal{{ $application->id_application }}">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-danger text-white">
<h5 class="modal-title">Apagar Candidatura</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">
Tem certeza que deseja apagar esta candidatura?
<p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
</div>
<div class="modal-footer">
<form action="{{ route('applications.destroy',$application->id_application) }}" method="POST">
@csrf
@method('DELETE')
<button class="btn btn-danger">Sim Apagar</button>
</form>
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
</div>
</div>
</div>
</div>
@empty
<tr>
<td colspan="6" class="text-center">Nenhuma candidatura encontrada.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

@if(auth()->user()->access_level != 1)
<div class="modal fade" id="addApplicationModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-primary text-white">
<h5 class="modal-title">Adicionar Candidatura</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data">
@csrf
<div class="modal-body">
<div class="row g-3">
<div class="col-md-6">
<label class="form-label">Bolsa</label>
<select name="id_scholarship" class="form-select" required>
<option value="">Selecione a bolsa</option>
@foreach($scholarships as $scholarship)
<option value="{{ $scholarship->id }}">{{ $scholarship->name }} ({{ $scholarship->status }})</option>
@endforeach
</select>
</div>
<div class="col-md-6">
<label class="form-label">Data da candidatura</label>
<input type="date" name="application_date" class="form-control" value="{{ date('Y-m-d') }}" required>
</div>
@foreach($fileFields as $field => $label)
<div class="col-md-6">
<label class="form-label">{{ $label }}</label>
<input type="file" name="{{ $field }}" class="form-control" accept=".pdf,.jpg,.png" required>
</div>
@endforeach
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-primary">Submeter candidatura</button>
</div>
</form>
</div>
</div>
</div>
@endif

</div>
@endsection
