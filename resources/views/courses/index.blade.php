@extends('main')

@section('content')

<div class="container mt-5">
    <h2>Cursos</h2>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botão para abrir modal de adicionar -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">Adicionar Curso</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Curso</th>
                <th>Departamento</th>
                <th>Faculdade</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->id_course}}</td>
                <td>{{ $course->course_name }}</td>
                <td>{{ $course->department->department_name ?? 'N/A' }}</td>
                <td>{{ $course->department->faculty->faculty_name ?? 'N/A' }}</td>
                <td>{{ $course->description }}</td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCourseModal{{ $course->id_course}}">Editar</button>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCourseModal{{ $course->id_course}}">Eliminar</button>
                </td>
            </tr>

            <!-- Modal Editar -->
            <div class="modal fade" id="editCourseModal{{ $course->id_course}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('courses.update', $course->id_course) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Curso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nome do Curso</label>
                                    <input type="text" name="course_name" class="form-control" value="{{ $course->course_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Departamento</label>
                                    <select name="department_id" class="form-control" required>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id_department }}" {{ $course->department_id == $dept->id_department ? 'selected' : '' }}>
                                                {{ $dept->department_name }} ({{ $dept->faculty->faculty_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Descrição</label>
                                    <textarea name="description" class="form-control">{{ $course->description }}</textarea>
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
            <div class="modal fade" id="deleteCourseModal{{ $course->id_course}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('courses.destroy', $course->id_course) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Deletar Curso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja deletar o curso "{{ $course->course_name }}"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Deletar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Adicionar Curso -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nome do Curso</label>
                        <input type="text" name="course_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Departamento</label>
                        <select name="department_id" class="form-control" required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id_department }}">{{ $dept->department_name }} ({{ $dept->faculty->faculty_name }})</option>
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
