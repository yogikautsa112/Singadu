<?php

namespace App\Exports;

use App\Models\Report;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $filteredDate;

    /**
     * Constructor to accept date filtering.
     *
     * @param array|null $dateRange
     */
    public function __construct($dateRange = null)
    {
        $this->filteredDate = $dateRange;
    }

    /**
     * Retrieve filtered reports.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Report::query()->with(['user', 'response']);

        // Apply date range filtering if provided
        if ($this->filteredDate) {
            $query->whereBetween('created_at', [
                $this->filteredDate['start'],
                $this->filteredDate['end']
            ]);
        }

        // Optional: Add ordering
        $query->orderBy('created_at', 'desc');

        return $query->get();
    }

    /**
     * Define headings for Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            "ID",
            "Email Pelapor",
            "Gambar",
            "Lokasi Laporan",
            "Jumlah Voting",
            "Deskripsi",
            "Dilaporkan Pada Tanggal",
            "Status Pengaduan",
            "Staff Terkait",
        ];
    }

    /**
     * Map report data for Excel export.
     *
     * @param \App\Models\Report $report
     * @return array
     */
    public function map($report): array
    {
        // Safely get vote count
        $totalVote = optional($report->voting)->count() ?? 0;

        // Safely get user email
        $userEmail = optional($report->user)->email ?? 'Tidak ada email';

        // Format date with fallback
        $reportDate = $report->created_at
            ? Carbon::parse($report->created_at)->translatedFormat('d F Y')
            : 'Tanggal Tidak Tersedia';

        // Construct location with null checks
        $location = implode(' -> ', array_filter([
            $report->province ?? '',
            $report->subdistrict ?? '',
            $report->regency ?? '',
            $report->village ?? '',
        ]));

        return [
            $report->id,
            $userEmail,
            $report->image ?? 'Tidak ada gambar',
            $location ?: 'Lokasi Tidak Diketahui',
            $totalVote === 0 ? 'Tidak ada voting' : $totalVote,
            $report->description ?? 'Tidak ada deskripsi',
            $reportDate,
            optional($report->response)->response_status ?? 'Tidak ada status',
            optional($report->response)->staf_id ?? 'Tidak ada staf',
        ];
    }

    /**
     * Apply styling to Excel worksheet.
     *
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Style the first row (headers)
        $sheet->getStyle('1')->getFont()->setBold(true);

        // Optional: Set column widths
        $sheet->getColumnDimension('A')->setWidth(10);  // ID
        $sheet->getColumnDimension('B')->setWidth(25);  // Email
        $sheet->getColumnDimension('C')->setWidth(20);  // Gambar
        $sheet->getColumnDimension('D')->setWidth(30);  // Lokasi
        $sheet->getColumnDimension('G')->setWidth(25);  // Tanggal
    }
}
