@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white pt-3">
            <h5 class="fw-bold text-primary mb-0">Form Tambah Embung</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('embung.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Nama Embung <span class="text-danger">*</span></label>
                        <input type="text" name="nama_embung" class="form-control" value="{{ old('nama_embung') }}" required>
                    </div>

                    <div class="col-12 mt-3">
                        <label class="form-label fw-bold">Pilih Kabupaten & Kecamatan</label>
                        
                        <div class="accordion" id="accordionWilayah">
                            @if(isset($wilayahNtb) && is_array($wilayahNtb))
                                @foreach ($wilayahNtb as $kabupaten => $kecamatans)
                                    <div class="accordion-item mb-2 border rounded">
                                        <h2 class="accordion-header" id="heading-{{ $loop->index }}">
                                            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}">
                                                <input class="form-check-input me-2 check-kabupaten" 
                                                       type="checkbox" 
                                                       name="kabupaten[]" 
                                                       value="{{ $kabupaten }}" 
                                                       data-target="group-{{ $loop->index }}">
                                                <strong>{{ $kabupaten }}</strong>
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $loop->index }}" class="accordion-collapse collapse" data-bs-parent="#accordionWilayah">
                                            <div class="accordion-body bg-light">
                                                <div class="row g-2 group-{{ $loop->index }}">
                                                    @foreach ($kecamatans as $kec)
                                                        <div class="col-md-3 col-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input check-kecamatan" 
                                                                       type="checkbox" 
                                                                       name="kecamatan[]" 
                                                                       value="{{ $kec }}" 
                                                                       id="kec-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                                <label class="form-check-label small" for="kec-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                                    {{ $kec }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Desa / Kelurahan</label>
                        <input type="text" name="desa" class="form-control" value="{{ old('desa') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Volume Tampungan (m³)</label>
                        <input type="number" step="0.01" name="volume_tampungan" class="form-control" value="{{ old('volume_tampungan') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Luas Genangan (Ha)</label>
                        <input type="number" step="0.01" name="luas_genangan" class="form-control" value="{{ old('luas_genangan') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sumber Air</label>
                        <input type="text" name="sumber_air" class="form-control" value="{{ old('sumber_air') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tahun Pembangunan</label>
                        <input type="number" name="tahun_pembangunan" class="form-control" value="{{ old('tahun_pembangunan') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" class="form-select">
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Fungsi</label>
                        <select name="status_fungsi" class="form-select">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('embung.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const kabCheckboxes = document.querySelectorAll('.check-kabupaten');
    kabCheckboxes.forEach(function (kabCheck) {
        kabCheck.addEventListener('change', function () {
            const groupClass = this.getAttribute('data-target');
            const kecCheckboxes = document.querySelectorAll('.' + groupClass + ' .check-kecamatan');
            kecCheckboxes.forEach(function (kecCheck) {
                kecCheck.checked = kabCheck.checked;
            });
        });
    });
});
</script>
@endsection