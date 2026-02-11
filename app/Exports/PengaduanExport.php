<?php

namespace App\Exports;

use App\Models\InputAspirasi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Http\Request;

class PengaduanExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = InputAspirasi::with(['kategori', 'siswa', 'aspirasi'])
            ->where(function ($q) {
                $q->whereHas('aspirasi', function ($qa) {
                    $qa->whereIn('status', ['Menunggu', 'Proses', 'Selesai']);
                })->orWhereDoesntHave('aspirasi');
            })
            ->leftJoin('aspirasi', 'input_aspirasi.id_pelaporan', '=', 'aspirasi.id_input_aspirasi')
            ->select('input_aspirasi.*');

        if ($this->request) {
            if ($this->request->filled('status')) {
                if ($this->request->status === 'Menunggu') {
                    $query->where(function ($q) {
                        $q->whereDoesntHave('aspirasi')
                            ->orWhereHas('aspirasi', function ($qa) {
                                $qa->where('status', 'Menunggu');
                            });
                    });
                } else {
                    $query->whereHas('aspirasi', function ($qa) {
                        $qa->where('status', $this->request->status);
                    });
                }
            }

            if ($this->request->filled('kategori')) {
                $query->where('input_aspirasi.id_kategori', $this->request->kategori);
            }

            if ($this->request->filled('siswa')) {
                $query->whereHas('siswa', function ($q) {
                    $q->where('nama', 'like', '%' . $this->request->siswa . '%')
                        ->orWhere('nis', 'like', '%' . $this->request->siswa . '%');
                });
            }

            if ($this->request->filled('tanggal')) {
                $query->whereDate('input_aspirasi.created_at', $this->request->tanggal);
            }

            if ($this->request->filled('bulan')) {
                $query->whereMonth('input_aspirasi.created_at', $this->request->bulan);
            }
        }

        return $query->orderByRaw("CASE
                WHEN aspirasi.status = 'Proses' THEN 2
                WHEN aspirasi.status = 'Selesai' THEN 3
                ELSE 1
            END")
            ->latest('input_aspirasi.created_at');
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Kategori',
            'Lokasi',
            'Uraian Masalah',
            'Status',
            'Tanggal Dibuat',
        ];
    }

    public function map($pengaduan): array
    {
        static $index = 0;
        $index++;
        $status = $pengaduan->aspirasi->status ?? 'Menunggu';

        return [
            $index,
            $pengaduan->nis,
            $pengaduan->siswa->nama ?? 'N/A',
            $pengaduan->siswa->kelas->nama_kelas ?? 'N/A',
            $pengaduan->kategori->ket_kategori ?? 'Umum',
            $pengaduan->lokasi,
            $pengaduan->ket,
            $status,
            $pengaduan->created_at->format('d-m-Y H:i'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->getSheet();
                $delegate = $sheet->getDelegate();

                $delegate->insertNewRowBefore(1, 3);

                $highestRow = $delegate->getHighestRow();
                $highestColumn = $delegate->getHighestColumn();

                $title = 'Laporan Rekapitulasi Pengaduan Sarana dan Prasarana';
                $subtitle = 'Rekapitulasi data pengaduan siswa sesuai filter yang dipilih.';

                $filterParts = [];
                if ($this->request) {
                    if ($this->request->filled('status')) $filterParts[] = 'Status: ' . $this->request->status;
                    if ($this->request->filled('kategori')) $filterParts[] = 'Kategori: ' . $this->request->kategori;
                    if ($this->request->filled('siswa')) $filterParts[] = 'Pelapor: ' . $this->request->siswa;
                    if ($this->request->filled('tanggal')) $filterParts[] = 'Tanggal: ' . $this->request->tanggal;
                    if ($this->request->filled('bulan')) $filterParts[] = 'Bulan: ' . $this->request->bulan;
                }
                $filterSummary = $filterParts ? implode(' | ', $filterParts) : 'Semua Data';
                $printedAt = 'Dicetak: ' . now()->format('d-m-Y H:i') . ' | ' . $filterSummary;

                $borderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];

                $delegate->mergeCells('A1:I1');
                $delegate->mergeCells('A2:I2');
                $delegate->mergeCells('A3:I3');

                $delegate->setCellValue('A1', $title);
                $delegate->setCellValue('A2', $subtitle);
                $delegate->setCellValue('A3', $printedAt);

                $delegate->getStyle('A1')->getFont()->setSize(14)->setBold(true);
                $delegate->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

                $delegate->getStyle('A2')->getFont()->setSize(10);
                $delegate->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

                $delegate->getStyle('A3')->getFont()->setSize(9);
                $delegate->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

                $headerRange = 'A4:I4';
                $delegate->getStyle($headerRange)->getFont()->setBold(true);
                $delegate->getStyle($headerRange)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F3F4F6');
                $delegate->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

                $delegate->getColumnDimension('A')->setWidth(5);
                $delegate->getColumnDimension('B')->setWidth(12);
                $delegate->getColumnDimension('C')->setWidth(25);
                $delegate->getColumnDimension('D')->setWidth(15);
                $delegate->getColumnDimension('E')->setWidth(18);
                $delegate->getColumnDimension('F')->setWidth(20);
                $delegate->getColumnDimension('G')->setWidth(50);
                $delegate->getColumnDimension('H')->setWidth(14);
                $delegate->getColumnDimension('I')->setWidth(20);

                if ($highestRow >= 5) {
                    $delegate->getStyle('G5:G' . $highestRow)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
                }

                $range = 'A1:' . $highestColumn . $highestRow;
                $delegate->getStyle($range)->applyFromArray($borderStyle);

                $delegate->getRowDimension(1)->setRowHeight(30);
                $delegate->getRowDimension(2)->setRowHeight(20);
                $delegate->getRowDimension(3)->setRowHeight(16);

                $delegate->getRowDimension(4)->setRowHeight(24);
            },
        ];
    }
}
