@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-dark"><i class="bi bi-water text-primary me-2"></i>Data Sungai</h2>
        <a href="{{ route('sungai.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Sungai Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Sungai</th>
                            <th>Panjang (km)</th>
                            <th>Kecamatan / Lokasi</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($sungaiList) && count($sungaiList) > 0)
                            @foreach($sungaiList as $index => $sungai)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sungai->nama_sungai }}</td>
                                    <td>{{ $sungai->panjang_km ? $sungai->panjang_km . ' km' : '-' }}</td>
                                    <td>{{ $sungai->lokasi ?? '-' }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('sungai.destroy', $sungai->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data sungai.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection