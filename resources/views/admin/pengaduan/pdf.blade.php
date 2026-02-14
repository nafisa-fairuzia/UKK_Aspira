<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan ASPIRA</title>
    <style>
        @page {
            margin: 1.2cm;
            size: A4 landscape;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            font-size: 8.5pt;
            line-height: 1.5;
            margin: 0;
        }

        .header-container {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 15px;
        }

        .title {
            font-size: 18pt;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }

        .subtitle {
            font-size: 9pt;
            color: #64748b;
            margin-top: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        th {
            background-color: #f8fafc;
            color: #1e293b;
            border: 1px solid #cbd5e1;
            padding: 8px 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 7.5pt;
        }

        td {
            border: 1px solid #e2e8f0;
            padding: 8px 6px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .col-no { width: 30px; text-align: center; color: #94a3b8; }
        .col-nama { width: 140px; }
        .col-tgl { width: 70px; text-align: center; }
        .col-kat { width: 100px; }
        .col-lok { width: 100px; }
        .col-deskripsi { width: auto; }
        .col-foto { width: 90px; text-align: center; }
        .col-status { width: 80px; text-align: center; }

        .text-bold { font-weight: bold; color: #0f172a; display: block; }
        .text-muted { font-size: 7.5pt; color: #64748b; margin-top: 2px; }

        .img-bukti {
            max-width: 80px;
            max-height: 60px;
            border: 1px solid #e2e8f0;
            padding: 2px;
            border-radius: 3px;
        }

        .status-label {
            font-weight: bold;
            font-size: 7.5pt;
            text-transform: uppercase;
        }
        
        /* Warna Status */
        .status-selesai { color: #10b981; }
        .status-proses { color: #3b82f6; }
        .status-pending { color: #f59e0b; }
    </style>
</head>

<body>

    <div class="header-container">
        <div class="title">LAPORAN REKAPITULASI PENGADUAN</div>
        <div class="subtitle">Sistem Pengaduan Sarana dan Prasarana Sekolah</div>
    </div>

    <table style="width: 100%; margin-bottom: 10px; font-size: 8pt; border: none;">
        <tr>
            <td style="border: none; padding: 0;">FILTER STATUS: <strong>{{ strtoupper($status ?? 'SEMUA DATA') }}</strong></td>
            <td style="border: none; padding: 0; text-align: right; color: #64748b;">
                Dicetak: {{ now()->translatedFormat('d/m/Y H:i') }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th class="col-no">NO</th>
                <th class="col-nama">Identitas Pelapor</th>
                <th class="col-tgl">Tanggal</th>
                <th class="col-kat">Kategori</th>
                <th class="col-lok">Lokasi</th>
                <th class="col-deskripsi">Deskripsi Laporan</th>
                <th class="col-foto">Lampiran</th>
                <th class="col-status">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduan as $p)
            <tr>
                <td class="col-no">{{ $loop->iteration }}</td>
                <td>
                    <span class="text-bold">{{ optional($p->siswa)->nama ?? '-' }}</span>
                    <span class="text-muted">{{ optional(optional($p->siswa)->kelas)->nama_kelas ?? '-' }}</span>
                </td>
                <td style="text-align: center;">{{ optional($p->created_at)->format('d/m/Y') }}</td>
                <td>{{ optional($p->kategori)->ket_kategori ?? '-' }}</td>
                <td>{{ $p->lokasi ?? '-' }}</td>
                <td>{{ $p->ket ?? '-' }}</td>
                <td class="col-foto">
                    @php
                        $imgHtml = '-';
                        if (!empty($p->gambar)) {
                            $fileName = basename($p->gambar);
                            $path = storage_path('app/public/aspirasi/' . $fileName);
                            if (file_exists($path)) {
                                $mime = @mime_content_type($path) ?: 'image/jpeg';
                                $base64 = base64_encode(file_get_contents($path));
                                $imgHtml = '<img src="data:'.$mime.';base64,'.$base64.'" class="img-bukti">';
                            }
                        }
                    @endphp
                    {!! $imgHtml !!}
                </td>
                <td class="col-status">
                    @php
                        $st = strtoupper(optional($p->aspirasi)->status ?? ($p->status ?? 'Menunggu'));
                        $classStatus = match($st) {
                            'SELESAI' => 'status-selesai',
                            'PROSES'  => 'status-proses',
                            default   => 'status-pending',
                        };
                    @endphp
                    <span class="status-label {{ $classStatus }}">
                        {{ $st }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:30px;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>