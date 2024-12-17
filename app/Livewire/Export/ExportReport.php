<?php

namespace App\Livewire\Export;

use App\Exports\ReportsExport;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportReport extends Component
{
    public $selectedDateRange = 'all'; // Default filter
    public $filteredDate = null; // For custom date filter

    // Watch for changes in selectedDateRange and filteredDate
    protected $updated = [
        'selectedDateRange' => 'export',
        'filteredDate' => 'export'
    ];

    // Function to handle the export
    public function export()
    {
        $filteredDate = null;

        if ($this->selectedDateRange == 'today') {
            $filteredDate = now()->format('Y-m-d'); // Today
        } elseif ($this->selectedDateRange == 'this_week') {
            $filteredDate = now()->startOfWeek()->format('Y-m-d'); // Start of this week
        } elseif ($this->selectedDateRange == 'this_month') {
            $filteredDate = now()->startOfMonth()->format('Y-m-d'); // Start of this month
        } elseif ($this->selectedDateRange == 'custom' && $this->filteredDate) {
            $filteredDate = $this->filteredDate; // Use custom date if selected
        }

        // Pass the filtered date to the export class and trigger the download
        return Excel::download(new ReportsExport($filteredDate), 'reports.xlsx');
    }
    public function render()
    {
        return view('livewire.export.export-report');
    }
}
