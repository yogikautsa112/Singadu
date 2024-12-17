<?php

namespace App\Livewire\Reports;

use App\Models\Report;
use Livewire\Component;

class ReportPage extends Component
{
    public function render()
    {
        return view('livewire.reports.report-page');
    }

    public function destroy($id)
{
    $report = Report::findOrFail($id);
    
    // Pastikan hanya pengguna yang membuat pengaduan yang dapat menghapusnya
    if ($report->user_id !== auth()->user()->id) {
        return redirect()->route('report.me')->with('error', 'Unauthorized action.');
    }
    
    // Hapus pengaduan jika belum ada tanggapan
    if (!$report->statement) {
        $report->delete();
        return redirect()->route('report.me')->with('success', 'Pengaduan berhasil dihapus.');
    }
    
    return redirect()->route('report.me')->with('error', 'Pengaduan sudah mendapatkan tanggapan dan tidak bisa dihapus.');
}

}
