@extends('main')

@section('content')
<div class="container mt-5">
    <h2>Lista de Departamentos</h2>

    <!-- Botão para abrir modal de adicionar -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">Adicionar Departamento</button>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Departamento</th>
                <th>Faculdade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->id_department }}</td>
                    <td>{{ $department->department_name }}</td>
                    <td>{{ $department->faculty->faculty_name ?? 'N/A' }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editDepartmentModal{{ $department->id_department }}">Editar</button>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteDepartmentModal{{ $department->id_department }}">Eliminar</button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                <div class="modal fade" id="editDepartmentModal{{ $department->id_department }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('departments.update', $department->id_department) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Departamento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nome do Departamento</label>
                                        <input type="text" name="department_name" class="form-control" value="{{ $department->department_name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Faculdade</label>
                                        <select name="faculty_id" class="form-control" required>
                                            @foreach($faculties as $faculty)
                                                <option value="{{ $faculty->id_faculty }}" @if($department->faculty_id == $faculty->id_faculty) selected @endif>
                                                    {{ $faculty->faculty_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Descrição</label>
                                        <textarea name="description" class="form-control">{{ $department->description }}</textarea>
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
                <div class="modal fade" id="deleteDepartmentModal{{ $department->id_department }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('departments.destroy', $department->id_department) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Eliminar Departamento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Tem certeza que deseja eliminar o departamento "{{ $department->department_name }}"?
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
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nome do Departamento</label>
                        <input type="text" name="department_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Faculdade</label>
                        <select name="faculty_id" class="form-control" required>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id_faculty }}">{{ $faculty->faculty_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Adicionar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
