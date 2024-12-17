<?php

namespace App\Livewire\Staff;

use App\Models\Report;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Manage extends Component
{
    use WithPagination;

    public $search = ''; // For search
    public $sortField = 'voting'; // Default sorting field is 'voting'
    public $sortOrder = 'desc'; // Default sort order

    public $selectedReportId = null;
    public $responseStatus = '';

    protected $queryString = ['search', 'sortField', 'sortOrder'];

    /**
     * Reset pagination when search changes.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Sort data by field.
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortOrder = 'asc';
        }
    }

    /**
     * Validate the response status before submitting.
     */
    public function validateResponseStatus()
    {
        $this->validate([
            'responseStatus' => 'required',
        ]);
    }

    /**
     * Select a report by its ID.
     */
    public function selectReport($reportId)
    {
        $this->selectedReportId = $reportId;
    }

    /**
     * Submit the response and update the report status.
     */
    public function submitResponse()
    {
        // Validasi input
        $this->validate([
            'selectedReportId' => 'required|exists:reports,id',
            'responseStatus' => 'required|in:ON_PROCESS,DONE,REJECT',
        ]);

        // Simpan report ID sebelum direset
        $reportId = $this->selectedReportId;

        try {
            // Buat response baru
            Response::create([
                'report_id' => $reportId,
                'staff_id' => Auth::user()->id,
                'response_status' => $this->responseStatus,
            ]);

            // Update status laporan
            $report = Report::findOrFail($reportId);
            $report->update([
                'status' => $this->responseStatus,
            ]);

            // Kirim pesan sukses
            Toaster::success('Respon berhasil disubmit');

            // Reset properti
            $this->reset(['selectedReportId', 'responseStatus']);

            // Redirect ke halaman manajemen respon
            return redirect()->route('response.manage', ['report_id' => $reportId]);
        } catch (\Exception $e) {
            // Tangani kesalahan
            Toaster::error('Gagal mengirim respon: ' . $e->getMessage());

            // Kembali ke halaman sebelumnya
            return back();
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        // Fetch reports with search, sorting, and pagination
        $reports = Report::query()
            ->where('description', 'like', '%' . $this->search . '%')
            ->orWhere('province', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortOrder)
            ->paginate(10);

        return view('livewire.staff.manage', [
            'reports' => $reports,
        ]);
    }
}
