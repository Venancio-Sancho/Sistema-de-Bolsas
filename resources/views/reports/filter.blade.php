@extends('main')

@section('content')

<div class="container">
    <h3>📅 Resultados Filtrados</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
        </thead>

        <tbody>
            @foreach($applications as $app)
                <tr>
                    <td>{{ $app->id }}</td>
                    <td>{{ $app->status }}</td>
                    <td>{{ $app->created_at }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection