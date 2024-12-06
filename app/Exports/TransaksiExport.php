<?php
namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TransaksiExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnFormatting
{
    /**
     * Mengambil semua data transaksi untuk diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mengambil data transaksi beserta relasi produk dan toko
        return Transaksi::with(['produk', 'toko'])->get()->map(function ($transaksi) {
            return [
                'ID Transaksi'   => $transaksi->id,
                'Nama Toko'      => $transaksi->toko ? $transaksi->toko->nama : 'N/A',
                'Nama Produk'    => $transaksi->produk ? $transaksi->produk->name : 'N/A',
                'Tipe Transaksi' => $transaksi->transactionType,
                'Tanggal Transaksi' => $this->formatDate($transaksi->transactionDate),
                'Tanggal Retur'  => $this->formatDate($transaksi->returDate),
                'Jumlah Terjual' => $transaksi->terjual,
                'Waktu Edar'     => $transaksi->waktuEdar,
                'Status'         => $transaksi->status,
            ];
        });
    }

    /**
     * Menambahkan judul kolom pada Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Toko',
            'Nama Produk',
            'Tipe Transaksi',
            'Tanggal Transaksi',
            'Tanggal Retur',
            'Jumlah Terjual',
            'Waktu Edar',
            'Status',
        ];
    }

    /**
     * Menambahkan title pada sheet.
     *
     * @return string
     */
    public function title(): string
    {
        return 'Transaksi';
    }

    /**
     * Menambahkan styling (border) pada sheet Excel.
     *
     * @param  \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @return void
     */
    public function styles($sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);  // Header tebal
        $sheet->getStyle('A1:I' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }

    /**
     * Format kolom untuk tanggal.
     *
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'E' => 'DD/MM/YYYY',  // Tanggal Transaksi
            'F' => 'DD/MM/YYYY',  // Tanggal Retur
        ];
    }

    /**
     * Fungsi untuk memformat tanggal menjadi format d/m/Y atau return 'N/A' jika null.
     *
     * @param mixed $date
     * @return string
     */
    private function formatDate($date)
    {
        if ($date instanceof Carbon) {
            return $date->format('d/m/Y');
        }

        if ($date && strtotime($date)) {
            return Carbon::parse($date)->format('d/m/Y');
        }

        return 'N/A';
    }
}
