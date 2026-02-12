<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan ASPIRA</title>
    <style>
        @page { margin: 1cm; size: A4 landscape; }
        body { font-family: sans-serif; color: #334155; font-size: 8pt; margin: 0; }
        
        /* Tabel Utama */
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th { background-color: #f8fafc; border: 1px solid #cbd5e1; padding: 5px; font-size: 7pt; }
        td { border: 1px solid #e2e8f0; padding: 5px; vertical-align: top; word-wrap: break-word; }

        /* KOLOM NOMOR: SANGAT KECIL */
        .col-no { width: 20px; text-align: center; color: #94a3b8; }
        
        /* KOLOM LAIN */
        .col-nama { width: 130px; }
        .col-tgl { width: 70px; text-align: center; }
        .col-kat { width: 100px; }
        .col-lok { width: 100px; }
        .col-foto { width: 90px; text-align: center; }
        .col-status { width: 80px; text-align: center; }
        /* Kolom Deskripsi dibiarkan tanpa width agar mengambil sisa ruang */
        .col-desk { width: auto; }

        /* Warna Status (Supaya tidak error di VS Code) */
        .status-SELESAI { color: #10b981; font-weight: bold; }
        .status-PROSES { color: #3b82f6; font-weight: bold; }
        .status-MENUNGGU { color: #f59e0b; font-weight: bold; }
        .status-default { color: #f59e0b; font-weight: bold; }

        .img-bukti { max-width: 70px; max-height: 50px; border-radius: 2px; }
    </style>
</head>

<body>

    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="margin:0">LAPORAN REKAPITULASI PENGADUAN</h2>
        <p style="margin:0; font-size: 9pt; color: #64748b;">Sistem Pengaduan Sarana dan Prasarana Sekolah</p>
    </div>

    <table>
        <colgroup>
            <col style="width: 25px;"> <col style="width: 130px;">
            <col style="width: 70px;">
            <col style="width: 100px;">
            <col style="width: 100px;">
            <col> <col style="width: 90px;">
            <col style="width: 80px;">
        </colgroup>
        <thead>
            <tr>
                <th class="col-no">#</th>
                <th>Identitas Pelapor</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Deskripsi Laporan</th>
                <th>Lampiran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pengaduan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $stRaw = optional($p->aspirasi)->status ?? ($p->status ?? 'MENUNGGU');
                $stClass = strtoupper($stRaw);
            ?>
            <tr>
                <td class="col-no"><?php echo e($loop->iteration); ?></td>
                <td>
                    <strong><?php echo e(optional($p->siswa)->nama ?? '-'); ?></strong><br>
                    <small style="color: #64748b"><?php echo e(optional(optional($p->siswa)->kelas)->nama_kelas ?? '-'); ?></small>
                </td>
                <td style="text-align: center;"><?php echo e(optional($p->created_at)->format('d/m/Y')); ?></td>
                <td><?php echo e(optional($p->kategori)->ket_kategori ?? '-'); ?></td>
                <td><?php echo e($p->lokasi ?? '-'); ?></td>
                <td><?php echo e($p->ket ?? '-'); ?></td>
                <td style="text-align: center;">
                    <?php if(!empty($p->gambar)): ?>
                        <?php
                            $path = storage_path('app/public/aspirasi/' . basename($p->gambar));
                            $base64 = file_exists($path) ? base64_encode(file_get_contents($path)) : null;
                        ?>
                        <?php if($base64): ?>
                            <img src="data:image/jpeg;base64,<?php echo e($base64); ?>" class="img-bukti">
                        <?php else: ?> - <?php endif; ?>
                    <?php else: ?> - <?php endif; ?>
                </td>
                <td style="text-align: center;">
                    <span class="status-<?php echo e($stClass); ?>">
                        <?php echo e($stClass); ?>

                    </span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center; padding:20px;">Data Kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/admin/pengaduan/pdf.blade.php ENDPATH**/ ?>