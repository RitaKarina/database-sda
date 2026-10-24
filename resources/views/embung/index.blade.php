@extends('layouts.app')

@section('title', 'Data Embung & Tampungan Air')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Embung</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-water me-2"></i> Daftar Embung & Tampungan Air</h6>
        <a href="{{ route('embung.create') }}" class="btn btn-primary btn-sm">
            <div class="d-flex gap-2">
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm d-print-none">
        <i class="fas fa-print me-1"></i> Cetak / PDF
    </button>
    <a href="{{ route('embung.create') }}" class="btn btn-primary btn-sm d-print-none">
        <i class="fas fa-plus me-1"></i> Tambah Embung
    </a>
</div>
            <i class="fas fa-plus me-1"></i> Tambah Embung
        </a>
    </div><!-- Form Filter & Pencarian -->
<form action="{{ route('embung.index') }}" method="GET" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="search" class="form-control" placeholder="Cari nama embung..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4">
        <select name="kabupaten_id" class="form-select">
    <option value="">-- Semua Kabupaten --</option>
    @if(isset($kabupatens))
        @foreach($kabupatens as $kab)
            <option value="{{ $kab }}" {{ request('kabupaten_id') == $kab ? 'selected' : '' }}>
                {{ $kab }}
            </option>
        @endforeach
    @endif
</select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Cari</button>
        <a href="{{ route('embung.index') }}" class="btn btn-outline-secondary" title="Reset Filter"><i class="fas fa-undo"></i></a>
    </div>
</form>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Embung</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan / Desa</th>
                        <th>Vol. Tampungan (m³)</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($embungs as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="fw-semibold">{{ $item->nama_embung }}</td>
                            <td>{{ $item->kabupaten->nama_kabupaten ?? '-' }}</td>
                            <td>{{ $item->kecamatan }} {{ $item->desa ? '('.$item->desa.')' : '' }}</td>
                            <td>{{ number_format($item->volume_tampungan, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $item->kondisi == 'Baik' ? 'success' : ($item->kondisi == 'Rusak Ringan' ? 'warning' : 'danger') }}">
                                    {{ $item->kondisi }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->status_fungsi == 'Aktif' ? 'info' : 'secondary' }}">
                                    {{ $item->status_fungsi }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('embung.show', $item->id) }}" class="btn btn-info btn-sm text-white" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('embung.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('embung.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data embung.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection