<?php

namespace App\Livewire\Reports;

use App\Models\Comment;
use App\Models\Report;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ShowReport extends Component
{
    public $reportId;
    public $report;
    public $comment;

    public function mount($reportId)
    {
        $this->reportId = $reportId;
        $this->report = Report::with('comments.user')->find($reportId);

        if ($this->report) {
            $this->report->incrementViews();
        }
    }

    public function addComment()
    {
        $this->validate([
            'comment' => 'required|string|max:1000',
        ]);
    
        // Menambahkan komentar ke database
        Comment::create([
            'report_id' => $this->report->id,
            'user_id' => auth()->user()->id,
            'comment' => $this->comment,
        ]);
    
        // Reset komentar
        $this->comment = '';
    
        // Emit event untuk memperbarui tampilan
        $this->dispatch('refreshReport');
        Toaster::success('Komentar berhasil ditambahkan');
    
        // Redirect kembali ke halaman laporan
        return redirect()->route('reports.index');
    }

    public function render()
    {
        return view('livewire.reports.show-report');
    }
}
