<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Bolsas</title>
    <style>
        body { font-family: Arial; }
        table { width:100%; border-collapse: collapse; }
        table, th, td { border:1px solid black; }
        th, td { padding:8px; text-align:center; }
    </style>
</head>
<body>

<h2>Relatório de Candidaturas</h2>

<p>Total: {{ $total }}</p>
<p>Aprovadas: {{ $approved }}</p>
<p>Rejeitadas: {{ $rejected }}</p>
<p>Pendentes: {{ $pending }}</p>

<table>
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

</body>
</html>