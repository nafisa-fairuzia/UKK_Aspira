<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? 'Daftar Pengaduan'); ?></title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            color: #1f2937;
        }

        .header {
            text-align: left;
            margin-bottom: 8px;
        }

        .brand {
            font-size: 18px;
            font-weight: 700;
        }

        .meta {
            font-size: 12px;
            color: #4b5563;
            margin-top: 4px
        }

        .title {
            text-align: center;
            margin: 10px 0 18px 0;
            font-size: 16px;
            font-weight: 700
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            vertical-align: top
        }

        th {
            background: #f3f4f6;
            text-align: left;
            font-weight: 700
        }

        .small {
            font-size: 10px;
            color: #6b7280
        }

        .nowrap {
            white-space: nowrap
        }

        .center {
            text-align: center
        }
    </style>
</head>

<body>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
        <div style="display:flex;align-items:center;gap:12px">
            <?php $logo = public_path('logo.png'); ?>
            <?php if(file_exists($logo)): ?>
                <?php $logoData = base64_encode(file_get_contents($logo)); $logoExt = pathinfo($logo, PATHINFO_EXTENSION); ?>
                <img src="data:image/<?php echo e($logoExt); ?>;base64,<?php echo e($logoData); ?>" style="height:48px;" alt="logo">
            <?php endif; ?>
            <div>
                <div class="brand">Sekolah / Instansi: ASPIRA</div>
                <div class="meta">Generated: <?php echo e(now()->format('d M Y H:i')); ?> WIB</div>
            </div>
        </div>
        <div style="text-align:right;font-size:12px;color:#374151">Report by: Admin Sistem</div>
    </div>

    <div class="title"><?php echo e($title ?? 'Daftar Pengaduan'); ?></div>

    <table>
        <thead>
            <tr>
                <th style="width:4%" class="center">No</th>
                <th style="width:8%">NIS</th>
                <th style="width:18%">Nama Siswa</th>
                <th style="width:8%">Kelas</th>
                <th style="width:10%">Kategori</th>
                <th style="width:10%">Lokasi</th>
                <th style="width:18%">Uraian Masalah</th>
                <th style="width:10%">Gambar</th>
                <th style="width:8%" class="center">Status</th>
                <th style="width:8%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            <?php $__empty_1 = true; $__currentLoopData = $pengaduan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $i++; $status = $p->aspirasi->status ?? 'Menunggu'; ?>
            <tr>
                <td class="center"><?php echo e($i); ?></td>
                <td class="nowrap"><?php echo e($p->nis); ?></td>
                <td><?php echo e($p->siswa->nama ?? 'N/A'); ?></td>
                <td><?php echo e($p->siswa->kelas->nama_kelas ?? 'N/A'); ?></td>
                <td><?php echo e($p->kategori->ket_kategori ?? 'Umum'); ?></td>
                <td><?php echo e($p->lokasi); ?></td>
                <td><?php echo e($p->ket); ?></td>
                <td class="center">
                    <?php if(!empty($p->gambar) && file_exists(public_path('storage/aspirasi/' . $p->gambar))): ?>
                        <?php
                            $imgPath = public_path('storage/aspirasi/' . $p->gambar);
                            $imgData = base64_encode(file_get_contents($imgPath));
                            $imgExt = pathinfo($imgPath, PATHINFO_EXTENSION);
                        ?>
                        <img src="data:image/<?php echo e($imgExt); ?>;base64,<?php echo e($imgData); ?>" style="max-width:100px;max-height:80px;border-radius:4px;border:1px solid #e5e7eb;">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="center"><?php echo e($status); ?></td>
                <td><?php echo e(optional($p->created_at)->format('d-m-Y H:i')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="10" class="center small">Tidak ada data untuk ditampilkan</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        // If the view is rendered directly in browser (fallback), trigger print dialog automatically
        window.addEventListener('load', function() {
            setTimeout(function(){ window.print(); }, 500);
        });
    </script>

</body>

</html><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/admin/pengaduan/print.blade.php ENDPATH**/ ?>