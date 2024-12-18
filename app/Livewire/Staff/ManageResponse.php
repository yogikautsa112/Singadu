<?php

namespace App\Livewire\Staff;

use App\Models\Progress;
use App\Models\Report;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageResponse extends Component
{
    public $reportId;
    public $progressDescription;
    public $showAddProgressModal = false;
    public $showDeleteProgressModal = false;
public $progressIdToDelete;


    protected $rules = [
        'progressDescription' => 'required|string|max:255',
    ];

    public function mount($report_id)
    {
        $this->reportId = $report_id;
    }

    public function toggleAddProgressModal()
    {
        $this->showAddProgressModal = !$this->showAddProgressModal;
    }
    public function addProgress()
    {
        $this->validate();

        $report = $this->getReportWithResponse();
        if (!$report) {
            Toaster::error('Laporan atau respon tidak ditemukan.');
            return;
        }

        $progress = Progress::firstOrCreate(
            ['response_id' => $report->response->id],
            ['histories' => []]
        );

        $newProgress = [
            'date' => now()->format('Y-m-d'),
            'description' => $this->progressDescription,
        ];

        $progress->histories = array_merge($progress->histories ?? [], [$newProgress]);
        $progress->save();

        $this->resetForm();
        Toaster::success('Progress berhasil ditambahkan.');
    }

    public function confirmDeleteProgress($progressId)
{
    $this->progressIdToDelete = $progressId;
    $this->showDeleteProgressModal = true;
}

public function deleteProgress()
{
    try {
        // Hapus progress berdasarkan ID
        $progress = Progress::findOrFail($this->progressIdToDelete);
        $progress->delete();

        // Refresh data report untuk memperbarui tampilan
        $this->report->refresh();

        // Emit notifikasi sukses
        $this->dispatch('progressDeleted', 'Progress berhasil dihapus.');

        // Reset state modal
        $this->reset('showDeleteProgressModal', 'progressIdToDelete');
    } catch (\Exception $e) {
        // Emit notifikasi error
        $this->dispatch('progressDeletionFailed', 'Gagal menghapus progress.');

        // Reset state modal
        $this->reset('showDeleteProgressModal', 'progressIdToDelete');
    }
}


    private function getReportWithResponse()
    {
        return Report::with('response')->find($this->reportId);
    }

    public function markAsCompleted()
    {
        $report = Report::find($this->reportId);

        if ($report && $report->response) {
            $report->response->update([
                'response_status' => 'DONE' // Sesuaikan dengan status yang Anda inginkan
            ]);

            Toaster::success( 'Laporan berhasil ditandai sebagai selesai.');

            // Redirect atau refresh halaman
            return redirect()->route('staff.dashboard', parameters: ['report_id' => $this->reportId]);
        }

        Toaster::error('Gagal menandai laporan sebagai selesai.');
    }

    private function resetForm()
    {
        $this->progressDescription = '';
        $this->showAddProgressModal = false;
    }


    public function render()
    {
        $report = Report::with([
            'response.progress' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
        ])->find($this->reportId);
        return view('livewire.staff.manage-response', compact('report'));
    }
}
