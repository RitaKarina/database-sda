@extends('layouts.app')

@section('title', 'Data Daerah Irigasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-water me-2"></i> Data Daerah Irigasi (DI)</h4>
    <a href="{{ route('daerah-irigasi.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i> Tambah DI Baru
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('daerah-irigasi.index') }}" method="GET" class="row g-2 mb-3">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari Nama DI..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fas fa-search me-1"></i> Cari</button>
                <a href="{{ route('daerah-irigasi.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset"><i class="fas fa-undo"></i></a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama DI</th>
                        <th>Kabupaten / Kota</th>
                        <th>Luas Baku (Ha)</th>
                        <th>IKSI (%)</th>
                        <th style="width: 18%;">Kelengkapan Data</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daerahIrigasis as $index => $item)
                    <tr>
                        <td>{{ $daerahIrigasis->firstItem() + $index }}</td>
                        <td><strong>{{ $item->nama_di }}</strong></td>
                        <td>
                            @if(is_array($item->kabupaten))
                                @foreach($item->kabupaten as $kab)
                                    <span class="badge bg-light text-dark border mb-1">{{ $kab }}</span>
                                @endforeach
                            @else
                                {{ $item->kabupaten ?? '-' }}
                            @endif
                        </td>
                        <td>{{ number_format($item->luas_baku ?? 0, 0, ',', '.') }} Ha</td>
                        <td>
                            <span class="fw-bold {{ ($item->iksi ?? 0) >= 70 ? 'text-success' : 'text-warning' }}">
                                {{ $item->iksi ?? '-' }}%
                            </span>
                        </td>
                        <td>
                            <!-- Tampilan Interval / Persentase Kelengkapan Data -->
                            <div class="d-flex align-items-center gap-2">
                                <span class="small fw-bold">{{ $item->kelengkapan_data }}%</span>
                                <div class="progress flex-grow-1" style="height: 6px;">
                                    <div class="progress-bar {{ $item->kelengkapan_data == 100 ? 'bg-success' : ($item->kelengkapan_data >= 60 ? 'bg-info' : 'bg-warning') }}" 
                                         style="width: {{ $item->kelengkapan_data }}%;">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <!-- Item Export Dokumen -->
                                <a href="{{ route('daerah-irigasi.export', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Export Dokumen">
                                    <i class="fas fa-file-export"></i>
                                </a>
                                <!-- Tombol Hapus -->
                                <form action="{{ route('daerah-irigasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data Daerah Irigasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $daerahIrigasis->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection