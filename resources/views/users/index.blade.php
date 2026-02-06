@extends('main')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Utilizadores</h2>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">+ Novo Utilizador</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Curso</th>
                <th>Nível</th>
                <th>Período</th>
                <th>Género</th>
                <th>Telefone</th>
                <th>Acções</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->course->course_name ?? '—' }}</td>
                    <td>{{ $u->level }}</td>
                    <td>{{ $u->period }}</td>
                    <td>{{ $u->gender }}</td>
                    <td>{{ $u->phone }}</td>

                    <td>

                        <a href="{{ route('users.edit', $u->id) }}" class="btn btn-warning btn-sm">Editar</a>

                        <!-- Botão que abre o modal -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $u->id }}">
                            Apagar
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal{{ $u->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Confirmar Eliminação</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Tens certeza que queres eliminar o utilizador <strong>{{ $u->name }}</strong>?
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Fim Modal -->

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection
