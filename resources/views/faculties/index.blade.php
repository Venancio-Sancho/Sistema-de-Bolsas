@extends('main')

@section('content')
<div class="container mt-5">
    <h2>Faculdades</h2>

    <!-- Botão adicionar -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addFacultyModal">Cadastrar Faculdade</button>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faculties as $faculty)
                <tr>
                    <td>{{ $faculty->id_faculty }}</td>
                    <td>{{ $faculty->faculty_name }}</td>
                    <td>{{ $faculty->description }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editFacultyModal{{ $faculty->id_faculty }}">Editar</button>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFacultyModal{{ $faculty->id_faculty }}">Eliminar</button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                <div class="modal fade" id="editFacultyModal{{ $faculty->id_faculty }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('faculties.update', $faculty->id_faculty) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Faculdade</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nome</label>
                                        <input type="text" name="faculty_name" class="form-control" value="{{ $faculty->faculty_name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Descrição</label>
                                        <textarea name="description" class="form-control">{{ $faculty->description }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Deletar -->
                <div class="modal fade" id="deleteFacultyModal{{ $faculty->id_faculty }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('faculties.destroy', $faculty->id_faculty) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Eliminar Faculdade</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Tem certeza que deseja eliminar a faculdade "{{ $faculty->faculty_name }}"?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Adicionar -->
<div class="modal fade" id="addFacultyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('faculties.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar Faculdade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nome</label>
                        <input type="text" name="faculty_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
