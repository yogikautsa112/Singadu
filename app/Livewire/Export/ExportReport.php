<?php

namespace App\Livewire\Export;

use App\Exports\ReportsExport;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportReport extends Component
{
    public $showDateModal = false;
    public $selectedDateRange = 'all'; // Default filter
    public $startDate = null;
    public $endDate = null;

    // Function to handle the export
    public function export()
    {
        $filteredDate = null;

        switch ($this->selectedDateRange) {
            case 'today':
                $filteredDate = [
                    'start' => now()->startOfDay(),
                    'end' => now()->endOfDay()
                ];
                break;
            case 'this_week':
                $filteredDate = [
                    'start' => now()->startOfWeek(),
                    'end' => now()->endOfWeek()
                ];
                break;
            case 'this_month':
                $filteredDate = [
                    'start' => now()->startOfMonth(),
                    'end' => now()->endOfMonth()
                ];
                break;
            case 'custom':
                $this->validate([
                    'startDate' => 'required|date',
                    'endDate' => 'required|date|after_or_equal:startDate'
                ]);

                $filteredDate = [
                    'start' => Carbon::parse($this->startDate)->startOfDay(),
                    'end' => Carbon::parse($this->endDate)->endOfDay()
                ];
                break;
            default:
                $filteredDate = null;
        }
        return Excel::download(new ReportsExport($filteredDate), 'reports.xlsx');
    }
    public function exportAll()
    {
        $this->selectedDateRange = 'all';
        return $this->export();
    }

    public function openDateModal()
    {
        $this->selectedDateRange = 'custom';
        $this->showDateModal = true;
    }

    public function closeDateModal()
    {
        $this->showDateModal = false;
        $this->reset(['startDate', 'endDate']);
        $this->selectedDateRange = 'all';
    }
    public function render()
    {
        return view('livewire.export.export-report');
    }
}
