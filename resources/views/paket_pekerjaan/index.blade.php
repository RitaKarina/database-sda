@extends('layouts.app')

@section('title', 'Data Paket Pekerjaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-tasks me-2"></i> Data Paket Pekerjaan (5 Tahun Terakhir)</h4>
    <a href="{{ route('paket-pekerjaan.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i> Tambah Paket
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Kabupaten</th>
                        <th>Tahun</th>
                        <th>Pagu (Rp)</th>
                        <th>Kontrak (Rp)</th>
                        <th>Kontraktor</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->nama_paket }}</strong></td>
                        <td>{{ $item->kabupaten->nama_kabupaten ?? '-' }}</td>
                        <td>{{ $item->tahun_anggaran }}</td>
                        <td>Rp {{ number_format($item->pagu_anggaran, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->nilai_kontrak, 0, ',', '.') }}</td>
                        <td>{{ $item->kontraktor ?? '-' }}</td>
                        <td><span class="badge bg-success">{{ $item->status_pekerjaan }}</span></td>
                        <td>
                            <form action="{{ route('paket-pekerjaan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Belum ada data paket pekerjaan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection