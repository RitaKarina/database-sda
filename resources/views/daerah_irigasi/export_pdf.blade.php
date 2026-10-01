<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen - {{ $daerahIrigasi->nama_di }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #fff; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="p-4">
    <div class="no-print mb-3 text-end">
        <button onclick="window.print()" class="btn btn-primary">Cetak / Simpan PDF</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <div class="text-center mb-4 border-bottom pb-3">
        <h4>DOKUMEN PROFIL DAERAH IRIGASI</h4>
        <h3 class="fw-bold text-uppercase">{{ $daerahIrigasi->nama_di }}</h3>
    </div>

    <table class="table table-bordered">
        <tr>
            <th style="width: 30%;">Kode DI</th>
            <td>{{ $daerahIrigasi->kode_di ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kabupaten</th>
            <td>{{ is_array($daerahIrigasi->kabupaten) ? implode(', ', $daerahIrigasi->kabupaten) : $daerahIrigasi->kabupaten }}</td>
        </tr>
        <tr>
            <th>Kecamatan</th>
            <td>{{ is_array($daerahIrigasi->kecamatan) ? implode(', ', $daerahIrigasi->kecamatan) : $daerahIrigasi->kecamatan }}</td>
        </tr>
        <tr>
            <th>Luas Baku (Ha)</th>
            <td>{{ number_format($daerahIrigasi->luas_baku ?? 0, 2) }} Ha</td>
        </tr>
        <tr>
            <th>Luas Fungsional (Ha)</th>
            <td>{{ number_format($daerahIrigasi->luas_fungsional ?? 0, 2) }} Ha</td>
        </tr>
        <tr>
            <th>Kewenangan</th>
            <td>{{ $daerahIrigasi->kewenangan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Sumber Air</th>
            <td>{{ $daerahIrigasi->sumber_air ?? '-' }}</td>
        </tr>
        <tr>
            <th>IKSI</th>
            <td>{{ $daerahIrigasi->iksi ?? '-' }}</td>
        </tr>
    </table>
</body>
</html>