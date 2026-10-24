@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- FontAwesome CDN untuk Icon Aksi -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Data Daerah Irigasi</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('daerah-irigasi.print-all') }}" target="_blank" class="btn btn-outline-dark px-3 rounded-3">
                <i class="fas fa-print me-1"></i> Cetak Semua
            </a>
            <a href="{{ route('daerah-irigasi.create') }}" class="btn btn-primary px-3 rounded-3">
                + Tambah Data
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-center align-middle">
                        <tr>
                            <th width="50" class="py-3">No</th>
                            <th class="py-3">Nama Daerah Irigasi</th>
                            <th class="py-3">Kabupaten & Kecamatan</th>
                            <th class="py-3">Luas Baku Permen 14 (Ha)</th>
                            <th class="py-3">Luas Fungsional Irigasi Teknis (Ha)</th>
                            <th class="py-3">Luas Fungsional Irigasi Non Teknis (Ha)</th>
                            <th class="py-3">IP (%)</th>
                            <th class="py-3">Nilai IKSI</th>
                            <th class="py-3">Thn Dok. Perencanaan</th>
                            <th width="140" class="py-3">Kelengkapan Data</th>
                            <th width="140" class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daerahIrigasi as $index => $item)
                            <tr>
                                <!-- No -->
                                <td class="text-center">{{ $daerahIrigasi->firstItem() + $index }}</td>

                                <!-- Nama Daerah Irigasi -->
                                <td>
                                    <a href="{{ route('daerah-irigasi.show', $item->id) }}" class="text-primary text-decoration-none fw-semibold">
                                        {{ $item->nama_di }}
                                    </a>
                                </td>

                                <!-- Kabupaten & Kecamatan -->
                                <td>
                                    <div class="fw-normal">
                                        @if(is_array($item->kabupaten))
                                            {{ implode(', ', $item->kabupaten) }}
                                        @else
                                            {{ $item->kabupaten ?? '-' }}
                                        @endif
                                    </div>
                                    <div class="text-muted small">
                                        @if(is_array($item->kecamatan))
                                            {{ implode(', ', $item->kecamatan) }}
                                        @else
                                            {{ $item->kecamatan ?? '-' }}
                                        @endif
                                    </div>
                                </td>

                                <!-- Luas area -->
                                <td class="text-center">
                                    {{ $item->luas_baku_permen_14 !== null ? number_format($item->luas_baku_permen_14, 2) : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $item->luas_fungsional_irigasi_teknis !== null ? number_format($item->luas_fungsional_irigasi_teknis, 2) : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $item->luas_fungsional_irigasi_non_teknis !== null ? number_format($item->luas_fungsional_irigasi_non_teknis, 2) : '-' }}
                                </td>

                                <!-- IP (%) -->
                                <td class="text-center">
                                    {{ $item->ip ?? '-' }}
                                </td>

                                <!-- Nilai IKSI -->
                                <td class="text-center">
                                    {{ $item->iksi ?? '-' }}
                                </td>

                                <!-- Thn Dok. Perencanaan -->
                                <td class="text-center">
                                    {{ $item->tahun_dokumen_perencanaan ?? '-' }}
                                </td>

                                <!-- Kelengkapan Data + Progress Bar -->
                                <td>
                                    <div class="small fw-bold mb-1">{{ $item->kelengkapan_data }}%</div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar {{ $item->kelengkapan_data < 50 ? 'bg-danger' : ($item->kelengkapan_data < 80 ? 'bg-warning' : 'bg-success') }}" 
                                             role="progressbar" 
                                             style="width: {{ $item->kelengkapan_data }}%;" 
                                             aria-valuenow="{{ $item->kelengkapan_data }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </td>

                                <!-- Fitur Aksi (Lihat, Edit, Print, Sampah) -->
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Aksi">
                                        <!-- 1. Melihat (Mata) -->
                                        <a href="{{ route('daerah-irigasi.show', $item->id) }}" 
                                           class="btn btn-outline-secondary btn-sm" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>

                                        <!-- 2. Edit (Pensil) -->
                                        <a href="{{ route('daerah-irigasi.edit', $item->id) }}" 
                                           class="btn btn-outline-secondary btn-sm" 
                                           title="Edit Data">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>

                                        <!-- 3. Print PDF (Printer) -->
                                        <a href="{{ route('daerah-irigasi.print', $item->id) }}" 
                                           target="_blank" 
                                           class="btn btn-outline-secondary btn-sm" 
                                           title="Cetak PDF">
                                            <i class="fas fa-print text-dark"></i>
                                        </a>

                                        <!-- 4. Sampah / Hapus (Tempat Sampah) -->
                                        <form action="{{ route('daerah-irigasi.destroy', $item->id) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-secondary btn-sm" title="Hapus Data">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-4 text-muted">Belum ada data daerah irigasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $daerahIrigasi->links() }}
    </div>
</div>
@endsection