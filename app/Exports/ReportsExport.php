<?php

namespace App\Exports;

use App\Models\Report;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    private $filteredDate;

    /**
     * Konstruktor untuk menerima filter tanggal.
     *
     * @param string|null $filteredDate
     */
    public function __construct($filteredDate = null)
    {
        $this->filteredDate = $filteredDate;
    }

    /**
     * Mengambil data yang difilter berdasarkan tanggal.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Report::query();

        // Apply the filtered date if provided
        if ($this->filteredDate) {
            // Ensure filteredDate is in the proper format (Y-m-d)
            $date = Carbon::parse($this->filteredDate)->format('Y-m-d');
            $query->whereDate('created_at', $date);
        }

        // Fetch the reports
        return $query->get();
    }

    /**
     * Mendefinisikan heading untuk file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            "#",
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
     * Memetakan setiap baris data menjadi format untuk file Excel.
     *
     * @param \App\Models\Report $report
     * @return array
     */
    public function map($report): array
    {
        // Get the voting data and count the total votes
        $voteData = $report->voting;
        $totalVote = is_array($voteData) ? count($voteData) : null;

        // Get the user's email (if available)
        $userEmail = $report->user->email ?? "Tidak ada email";

        // Format the report's created_at date using Carbon
        $reportDate = Carbon::parse($report->created_at)->translatedFormat('d F Y');

        // Concatenate the location details into a single string
        $location = implode('->', [
            $report->province,
            $report->subdistrict,
            $report->regency,
            $report->village,
        ]);

        return [
            $report->id,
            $userEmail,
            $report->image,
            $location,
            ($totalVote === null || $totalVote === 0) ? 'Kosong' : $totalVote,
            $report->description,
            $reportDate,  // Formatted date
            $report->response->response_status ?? 'Tidak ada status',  // Default response status if null
            $report->response->staf_id ?? 'Tidak ada staf',  // Default staf_id if null
        ];
    }
}
