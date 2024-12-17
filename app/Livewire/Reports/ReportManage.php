<?php

namespace App\Livewire\Reports;

use App\Models\Report;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Masmerise\Toaster\Toaster;

class ReportManage extends Component
{
    use WithPagination;

    public $activeTab = 'data';
    public $selectedReportId = null;

    public function mount()
    {
        $this->selectedReportId = Report::first()?->id;
    }

    public function changeTab($tab, $reportId)
    {
        $this->activeTab = $tab;
        $this->selectedReportId = $reportId;
    }

    public function deleteReport($reportId)
    {
        $report = Report::findOrFail($reportId);

        // Check if report has no response before deletion
        if (!$report->response) {
            $report->delete();
            Toaster::success('Laporan berhasil dihapus.');

            // Reset selected report if needed
            $this->selectedReportId = Report::first()?->id;
        } else {
            Toaster::error('Laporan tidak dapat dihapus karena sudah memiliki tanggapan.');
        }
    }

    public function render()
    {
        $reports = Report::with('response')
            ->latest()
            ->paginate(5);
        return view('livewire.reports.report-manage', [ 
            'reports' => $reports
        ]);
    }
}
