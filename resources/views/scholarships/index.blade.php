@extends('main')

@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">

        {{-- Cabeçalho --}}
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Bolsas</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Página Inicial</a></li>
                        <li class="breadcrumb-item active">Bolsas</li>
                    </ul>
                </div>
                @can('excluir')
                <div class="col-auto text-end float-end ms-auto">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScholarship">
                        <i class="fas fa-plus"></i> Adicionar Bolsa
                    </a>
                </div>
             @endcan
            </div>
        </div>

        {{-- Tabela --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Descrição</th>
                                        <th>Requisitos</th>
                                        <th>Início</th>
                                        <th>Fim</th>
                                        <th>Status</th>
                                         @can('excluir')
                                        <th class="text-end">Ação</th>
                                        @endcan
                                    </tr>
                                </thead>

                                <tbody>
                                @forelse($scholarships as $scholarship)
                                    <tr>
                                        <td>{{ $scholarship->name }}</td>
                                        <td>{{ $scholarship->type }}</td>
                                        <td>{{ Str::limit($scholarship->description,50) }}</td>

                                        {{-- Botão que abre o modal --}}
                                        <td>
                                            <button class="btn btn-info btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewRequirements{{ $scholarship->id }}">
                                                Ver Mais
                                            </button>
                                        </td>

                                        <td>{{ \Carbon\Carbon::parse($scholarship->start_date)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($scholarship->end_date)->format('d/m/Y') }}</td>
                                        <td>{{ $scholarship->status }}</td>
                                          @can('excluir')
                                        <td class="text-end">
                                            <button class="btn btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editScholarship{{ $scholarship->id }}">
                                                Editar
                                            </button>

                                            <button class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteScholarship{{ $scholarship->id }}">
                                             Eliminar
                                            </button>
                                        </td>
                                        @endcan
                                    </tr>

                                    {{-- MODAL VER REQUISITOS --}}
                                    <div class="modal fade" id="viewRequirements{{ $scholarship->id }}" tabindex="-1">
                                      <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">

                                          <div class="modal-header">
                                            <h5 class="modal-title">Requisitos: {{ $scholarship->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                          </div>

                                          <div class="modal-body">
                                            <pre style="white-space: pre-wrap; background:#f8f9fa; padding:15px; border-radius:6px;">
{{ $scholarship->requirements }}
                                            </pre>
                                          </div>

                                          <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                          </div>

                                        </div>
                                      </div>
                                    </div>

                                    {{-- MODAL EDITAR --}}
                                    <div class="modal fade" id="editScholarship{{ $scholarship->id }}" tabindex="-1">
                                      <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                          <form action="{{ route('scholarships.update', $scholarship->id) }}" method="POST">
                                            @csrf @method('PUT')

                                            <div class="modal-header">
                                              <h5 class="modal-title">Editar Bolsa</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                              <div class="mb-3">
                                                <label>Nome</label>
                                                <input type="text" name="name" value="{{ $scholarship->name }}" class="form-control" required>
                                              </div>

                                              <div class="mb-3">
                                                <label>Tipo</label>
                                                <select name="type" class="form-control scholarshipTypeEdit" data-id="{{ $scholarship->id }}" required>
                                                  <option value="Completa" {{ $scholarship->type==="Completa"?"selected":"" }}>Completa</option>
                                                  <option value="Parcial" {{ $scholarship->type==="Parcial"?"selected":"" }}>Parcial</option>
                                                </select>
                                              </div>

                                              <div class="mb-3">
                                                <label>Descrição</label>
                                                <textarea name="description" id="description{{ $scholarship->id }}" class="form-control" required>{{ $scholarship->description }}</textarea>
                                              </div>

                                              <div class="mb-3">
                                                <label>Requisitos</label>
                                                <textarea name="requirements" id="requirements{{ $scholarship->id }}" class="form-control" required>{{ $scholarship->requirements }}</textarea>
                                              </div>

                                              <div class="mb-3">
                                                <label>Data de Início</label>
                                                <input type="date" name="start_date" value="{{ $scholarship->start_date }}" class="form-control" required>
                                              </div>

                                              <div class="mb-3">
                                                <label>Data de Fim</label>
                                                <input type="date" name="end_date" value="{{ $scholarship->end_date }}" class="form-control" required>
                                              </div>

                                      
                                              <div class="mb-3">
                                                <label>Status</label>
                                                <select name="status" class="form-control" required>
                                                  <option value="Disponível" {{ $scholarship->status==='Disponível'?'selected':'' }}>Disponível</option>
                                                  <option value="Indisponível" {{ $scholarship->status==='Indisponível'?'selected':'' }}>Indisponível</option>
                                                </select>
                                              </div>
                                              

                                            </div>

                                            <div class="modal-footer">
                                              <button type="submit" class="btn btn-success">Atualizar</button>
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            </div>

                                          </form>
                                        </div>
                                      </div>
                                    </div>

                                    {{-- MODAL DELETE --}}
                                    <div class="modal fade" id="deleteScholarship{{ $scholarship->id }}" tabindex="-1">
                                      <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">

                                          <form action="{{ route('scholarships.destroy', $scholarship->id) }}" method="POST">
                                            @csrf @method('DELETE')

                                            <div class="modal-header">
                                              <h5 class="modal-title">Eliminar Bolsa</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                              Tem certeza que deseja Eliminar:
                                              <strong>{{ $scholarship->name }}</strong>?
                                            </div>

                                            <div class="modal-footer">
                                              <button type="submit" class="btn btn-danger">Eliminar</button>
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            </div>

                                          </form>

                                        </div>
                                      </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Nenhuma bolsa encontrada</td>
                                    </tr>
                                @endforelse
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


{{-- MODAL ADICIONAR --}}
<div class="modal fade" id="addScholarship" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form action="{{ route('scholarships.store') }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <h5 class="modal-title">Adicionar Bolsa</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Tipo</label>
            <select name="type" id="scholarshipType" class="form-control" required>
              <option value="">-- Selecionar --</option>
              <option value="Completa">Completa</option>
              <option value="Parcial">Parcial</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Descrição</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label>Requisitos</label>
            <textarea name="requirements" id="requirements" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label>Data de Início</label>
            <input type="date" name="start_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Data de Fim</label>
            <input type="date" name="end_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
              <option value="Disponível">Disponível</option>
              <option value="Indisponível">Indisponível</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>

      </form>

    </div>
  </div>
</div>


{{-- JS — Preenchimento Automático --}}
<script>
document.getElementById('scholarshipType').addEventListener('change', function () {

    const desc = document.getElementById('description');
    const req = document.getElementById('requirements');

    const requisitos = `Dados Sociais e Económicos:
* Bilhete
* Atestado de pobreza
* Declaração de bairro
* Declaração de agregado familiar
* Declaração de rendimento

Dados Académicos:
* Aproveitamento acadêmico`;

    if (this.value === "Completa") {
        desc.value = "Inserção de inscrição, ajuda de custos com alimentação e moradia";
        req.value = requisitos;
    } else if (this.value === "Parcial") {
        desc.value = "Inserção de inscrição";
        req.value = requisitos;
    } else {
        desc.value = "";
        req.value = "";
    }
});

document.querySelectorAll('.scholarshipTypeEdit').forEach(function(sel){
    sel.addEventListener('change', function(){
        const id = this.dataset.id;

        const desc = document.getElementById("description"+id);
        const req = document.getElementById("requirements"+id);

        const requisitos = `Dados Sociais e Económicos:
* Bilhete
* Atestado de pobreza
* Declaração de bairro
* Declaração de agregado familiar
* Declaração de rendimento

Dados Académicos:
* Aproveitamento acadêmico`;

        if (this.value === "Completa") {
            desc.value = "Inserção de inscrição, ajuda de custos com alimentação e moradia";
            req.value = requisitos;
        } else if (this.value === "Parcial") {
            desc.value = "Inserção de inscrição";
            req.value = requisitos;
        } else {
            desc.value = "";
            req.value = "";
        }

    });
});
</script>

@endsection
