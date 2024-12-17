<?php

namespace App\Livewire;

use App\Models\Report;
use Livewire\Component;

class ReportChart extends Component
{
    public $labels = [];
    public $complaintsData = [];
    public $responsesData = [];

    public function mount()
    {
        // Jumlah Pengaduan
        $complaintsData = Report::select('province', Report::raw('COUNT(id) as total_complaints'))
            ->groupBy('province')
            ->get();

        // Jumlah Tanggapan
        $responsesData = Report::select(
            'province',
            Report::raw('SUM(JSON_LENGTH(voting)) as total_responses')
        )
            ->groupBy('province')
            ->get();

        // Memisahkan data untuk chart
        $this->labels = $complaintsData->pluck('province'); // Label provinsi

        // Convert to array using ->toArray()
        $this->complaintsData = $complaintsData->pluck('total_complaints')->toArray();
        $this->responsesData = $responsesData->pluck('total_responses')
            ->map(function ($value) {
                return (int) $value;
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.report-chart', [
            'labels' => $this->labels,
            'complaintsData' => $this->complaintsData,
            'responsesData' => $this->responsesData
        ]);
    }
}
