@extends('layouts.app')

@section('title', 'Dashboard SDA')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-2">Total Daerah Irigasi</h6>
                    <h2 class="display-6 fw-bold mb-0">{{ $totalIrigasi }}</h2>
                </div>
                <i class="fas fa-water fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-2">Total Embung</h6>
                    <h2 class="display-6 fw-bold mb-0">{{ $totalEmbung }}</h2>
                </div>
                <i class="fas fa-swimming-pool fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-2">Total Bendungan</h6>
                    <h2 class="display-6 fw-bold mb-0">{{ $totalBendungan }}</h2>
                </div>
                <i class="fas fa-archway fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary"><i class="fas fa-chart-bar me-2"></i> Grafik Kondisi Infrastruktur SDA</h6>
            </div>
            <div class="card-body">
                <canvas id="kondisiChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary"><i class="fas fa-info-circle me-2"></i> Ringkasan Sistem</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Sistem Informasi Database Sumber Daya Air (SI SDA) menyediakan data terintegrasi mencakup Irigasi, Embung, Bendungan, serta Sungai/DAS secara real-time.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('kondisiChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
            datasets: [{
                label: 'Jumlah Unit Infrastruktur',
                data: [{{ $kondisiBaik }}, {{ $kondisiRusakRingan }}, {{ $kondisiRusakBerat }}],
                backgroundColor: ['#198754', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
</script>
@endsection