<?php

namespace App\Livewire\Staff;

use App\Models\Progress;
use App\Models\Report;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AddProgres extends Component
{
    public $reportId;
    public $progressDescription;
    public $showAddProgressModal = false;

    public function mount($reportId)
    {
        $this->reportId = $reportId;
    }

    public function addProgress()
    {
        // Validasi input
        $validatedData = Validator::make(
            ['progressDescription' => $this->progressDescription],
            ['progressDescription' => 'required|string|max:255']
        )->validate();

        // Cari laporan berdasarkan ID
        $report = Report::find($this->reportId);

        if (!$report) {
            session()->flash('error', 'Laporan tidak ditemukan.');
            return;
        }

        // Tambahkan progress baru ke laporan
        $progress = new Progress();
        $progress->report_id = $report->id;
        $progress->histories = $validatedData['progressDescription'];
        $progress->save();

        // Reset input dan tutup modal
        $this->progressDescription = '';
        $this->showAddProgressModal = false;

        // Refresh data pada komponen
        $this->emit('progressAdded');

        session()->flash('success', 'Progress berhasil ditambahkan.');
    }

    public function render()
    {
        $report = Report::with('progress')->find($this->reportId);

        return view('livewire.staff.manage-response', [
            'report' => $report,
        ]);
    }
}
