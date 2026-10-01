@extends('layouts.app')

@section('title', 'Data Perencanaan SDA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-clipboard-list me-2"></i> Data Perencanaan (Renstra, RPJMD, Renja, DED, RC)</h4>
    <a href="{{ route('perencanaan.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i> Tambah Usulan
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
        <!-- Form Search & Filter -->
        <form action="{{ route('perencanaan.index') }}" method="GET" class="row g-2 mb-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari usulan kegiatan / kategori..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <input type="number" name="tahun" class="form-control form-control-sm" placeholder="Filter Tahun" value="{{ request('tahun') }}">
            </div>
            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fas fa-search me-1"></i> Cari</button>
                <a href="{{ route('perencanaan.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset"><i class="fas fa-undo"></i></a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Usulan Kegiatan</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Status DED</th>
                        <th>Status RC</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perencanaans as $index => $item)
                    <tr>
                        <td>{{ $perencanaans->firstItem() + $index }}</td>
                        <td><strong>{{ $item->usulan_kegiatan }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $item->kategori_perencanaan }}</span></td>
                        <td>{{ $item->tahun_perencanaan }}</td>
                        <td>
                            <span class="badge {{ $item->status_ded == 'Ada' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $item->status_ded }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $item->status_rc == 'Ada' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $item->status_rc }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('perencanaan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data perencanaan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $perencanaans->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection