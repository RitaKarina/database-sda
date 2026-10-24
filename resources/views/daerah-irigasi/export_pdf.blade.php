<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Daerah Irigasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #fff; color: #1f2937; font-size: 11px; }
        @media print { .no-print { display: none !important; } body { margin: 12mm !important; padding: 0 !important; } }
        .header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #0d6efd; padding-bottom: 12px; margin-bottom: 20px; }
        .p-logo { width: auto; height: 56px; flex: 0 0 auto; object-fit: contain; }
        .title-wrap { flex: 1; text-align: center; }
        .print-date { font-size: 11px; font-weight: bold; }
        .record-title { text-align: center; font-size: 15px; margin: 18px 0 12px; }
        .section-title { font-size: 12px; margin: 16px 0 5px; padding: 5px 7px; color: #12345a; background: #eaf1f8; border-left: 3px solid #0d6efd; page-break-after: avoid; }
        .report-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .report-table, .report-table th, .report-table td { border: 1px solid #64748b; }
        .report-table th, .report-table td { padding: 5px 7px; text-align: left; vertical-align: top; }
        .report-table th { width: 34%; background: #f2f2f2; }
        .report-table tr { page-break-inside: avoid; break-inside: avoid; }
        .scheme-preview { display: block; max-width: 100%; max-height: 600px; margin: 8px auto 16px; object-fit: contain; }
        .map-link { overflow-wrap: anywhere; }
        .signature-wrap { margin: 34px 0 12px; display: flex; justify-content: flex-end; page-break-inside: avoid; break-inside: avoid; }
        .signature-box { width: 285px; max-width: 100%; text-align: left; }
        .signature-role { text-align: center; font-weight: bold; }
        .signature-space { height: 90px; }
        .signature-name, .signature-nip { text-align: center; overflow-wrap: anywhere; line-height: 1.4; }
        .signature-name { font-weight: bold; }
        .signature-print-control { margin: 12px 0; text-align: right; }
        .signature-print-control button { padding: 7px 12px; cursor: pointer; }
        .signature-dialog { width: min(90vw, 480px); border: 1px solid #cbd5e1; border-radius: 6px; padding: 20px; }
        .signature-dialog::backdrop { background: rgb(0 0 0 / 35%); }
        .signature-fields { display: grid; gap: 12px; margin-bottom: 16px; }
        .signature-fields label { display: block; margin-bottom: 4px; font-weight: bold; }
        .signature-fields input { width: 100%; box-sizing: border-box; padding: 6px 8px; }
        .signature-dialog-actions { display: flex; justify-content: flex-end; gap: 8px; }
        .signature-dialog-actions button { padding: 7px 12px; cursor: pointer; }
        .report-record + .report-record { page-break-before: always; break-before: page; }
    </style>
</head>
<body class="p-4">
    @php $records = collect($daerahIrigasi); @endphp

    <div class="header">
        <x-logo size="56" class="p-logo" />
        <div class="title-wrap">
            <h4 class="mb-1">DATABASE SUMBER DAYA AIR</h4>
            <h3 class="fw-bold text-uppercase mb-0">{{ $records->count() > 1 ? 'LAPORAN DAERAH IRIGASI' : 'DOKUMEN PROFIL DAERAH IRIGASI' }}</h3>
        </div>
        <div class="print-date">Tanggal Cetak: {{ date('d-m-Y') }}</div>
    </div>

    @foreach ($records as $item)
        @include('daerah-irigasi.partials.report-details', ['item' => $item])
    @endforeach

    @include('daerah-irigasi.partials.signature-block')
    @include('daerah-irigasi.partials.signature-prompt')

</body>
</html>