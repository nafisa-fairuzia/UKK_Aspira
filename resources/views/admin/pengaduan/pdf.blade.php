<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan ASPIRA</title>
    <style>
        @page {
            margin: 1cm;
            size: A4 landscape;
        }

        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            font-size: 9pt;
            margin: 0;
        }

        /* Judul Simpel */
        .title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        /* Tabel Minimalis */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th {
            background-color: #f2f2f2;
            border: 1px solid #999;
            padding: 8px 4px;
            font-weight: bold;
            text-align: center;
        }

        td {
            border: 1px solid #ccc;
            padding: 6px 4px;
            vertical-align: middle;
            word-wrap: break-word;
        }

        /* Lebar Kolom Diatur Ketat */
        .col-no {
            width: 25px;
            text-align: center;
        }

        .col-nama {
            width: 120px;
        }

        .col-tgl {
            width: 70px;
            text-align: center;
        }

        .col-kat {
            width: 90px;
        }

        .col-lok {
            width: 90px;
        }

        .col-foto {
            width: 90px;
            text-align: center;
        }

        .col-status {
            width: 70px;
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .img-bukti {
            max-width: 80px;
            max-height: 60px;
            border-radius: 2px;
        }

        .status-text {
            font-weight: bold;
            font-size: 8pt;
        }

        .info-header {
            margin-bottom: 10px;
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="title">LAPORAN REKAPITULASI</div>

    <table class="info-header" style="border: none; margin-bottom: 15px;">
        <tr>
            <td style="border: none; padding: 0;">Status: <strong>{{ strtoupper($status ?? 'SEMUA') }}</strong></td>
            <td style="border: none; padding: 0; text-align: right;">Tanggal Cetak: {{ now()->format('d/m/Y') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-nama">Pelapor</th>
                <th class="col-tgl">Tanggal</th>
                <th class="col-kat">Kategori</th>
                <th class="col-lok">Lokasi</th>
                <th>Deskripsi</th>
                <th class="col-foto">Bukti</th>
                <th class="col-status">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduan as $p)
            <tr>
                <td class="col-no">{{ $loop->iteration }}</td>
                <td>
                    <div class="text-bold">{{ optional($p->siswa)->nama ?? '-' }}</div>
                    <div style="font-size: 8pt; color: #666;">{{ optional(optional($p->siswa)->kelas)->nama_kelas ?? '-' }}</div>
                </td>
                <td class="col-tgl">{{ optional($p->created_at)->format('d/m/Y') }}</td>
                <td>{{ optional($p->kategori)->ket_kategori ?? '-' }}</td>
                <td>{{ $p->lokasi ?? '-' }}</td>
                <td style="font-size: 8.5pt;">{{ $p->ket ?? '-' }}</td>
                <td class="col-foto">
                    @php
                    $imgHtml = '<span style="color: #ccc;">-</span>';
                    if (!empty($p->gambar)) {
                    // possible locations for the image
                    $possible = [
                    public_path('storage/aspirasi/' . $p->gambar),
                    storage_path('app/public/aspirasi/' . $p->gambar),
                    storage_path('app/aspirasi/' . $p->gambar)
                    ];

                    $found = null;
                    foreach ($possible as $candidate) {
                    if ($candidate && file_exists($candidate)) {
                    $found = $candidate;
                    break;
                    }
                    }

                    if ($found) {
                    try {
                    $fileContents = file_get_contents($found);
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $found) ?: 'image/jpeg';
                    finfo_close($finfo);
                    $base64 = base64_encode($fileContents);
                    $imgHtml = '<img src="data:'.$mime.';base64,'.$base64.'" class="img-bukti">';
                    } catch (\Exception $e) {
                    // fallback: show placeholder
                    $imgHtml = '<span style="color: #ccc;">-</span>';
                    }
                    }
                    }
                    @endphp
                    {!! $imgHtml !!}
                </td>
                <td class="col-status">
                    @php
                    $status = optional($p->aspirasi)->status ?? ($p->status ?? 'Menunggu');
                    $color = ($status == 'Selesai') ? '#10b981' : (($status == 'Proses') ? '#0ea5e9' : '#f59e0b');
                    @endphp
                    <span class="status-text" style="color: {{ $color }};">{{ strtoupper($status) }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">Data Tidak Ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; float: right; width: 200px; text-align: center;">
        <p>Mengetahui,</p>
        <div style="height: 50px;"></div>
        <p><strong>( Admin ASPIRA )</strong></p>
    </div>

</body>

</html>