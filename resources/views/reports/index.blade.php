@extends('main')

@section('content')

<div class="container py-4">

    <h3 class="mb-4 fw-bold">📊 Relatório e Estatísticas</h3>

      <!-- BOTÃO -->
   <div class="d-flex justify-content-between align-items-center mb-3">

    <a href="{{ route('reports.pdf') }}" class="btn btn-danger export-btn d-flex align-items-center gap-1">
        <i class="bi bi-file-earmark-pdf"></i>
        Exportar PDF
    </a>

</div>

    <!-- CARDS -->
    <div class="row g-3">

        @php
            $cards = [
                ['title' => 'Total', 'value' => $total, 'color' => 'primary', 'icon' => 'bi-bar-chart'],
                ['title' => 'Aprovadas', 'value' => $approved, 'color' => 'success', 'icon' => 'bi-check-circle'],
                ['title' => 'Rejeitadas', 'value' => $rejected, 'color' => 'danger', 'icon' => 'bi-x-circle'],
                ['title' => 'Pendentes', 'value' => $pending, 'color' => 'warning', 'icon' => 'bi-hourglass']
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">{{ $card['title'] }}</small>
                        <h3 class="fw-bold mb-0">{{ $card['value'] }}</h3>
                    </div>
                    <div class="bg-{{ $card['color'] }} text-white p-3 rounded-circle">
                        <i class="bi {{ $card['icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>

  

    <!-- FILTRO -->
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-body">
            <form method="POST" action="{{ route('reports.filter') }}">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="date" name="start_date" class="form-control rounded-pill" required>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="end_date" class="form-control rounded-pill" required>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-dark w-100 rounded-pill">
                            🔍 Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- GRÁFICO -->
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Distribuição de Candidaturas</h6>
            <div style="max-height: 300px;">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Aprovadas', 'Rejeitadas', 'Pendentes'],
        datasets: [{
            label: 'Candidaturas',
            data: [{{ $approved }}, {{ $rejected }}, {{ $pending }}],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

@endsection