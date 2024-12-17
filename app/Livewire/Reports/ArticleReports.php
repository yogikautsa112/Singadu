<?php

namespace App\Livewire\Reports;

use App\Models\Report;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ArticleReports extends Component
{
    public $selectedProvince = ''; // For province selection
    public $reports = [];
    public $provinces = []; // For storing provinces
    public $search = ''; // For storing the search query

    // To initialize with all reports
    public function mount()
    {
        $this->fetchProvinces(); // Fetch provinces on mount
        $this->reports = Report::all(); // Fetch all reports initially
    }

    // Fetch provinces from the API
    public function fetchProvinces()
    {
        try {
            $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
            $this->provinces = $response->json(); // Assign provinces
        } catch (\Exception $e) {
            $this->provinces = []; // Handle failure
            session()->flash('error', 'Failed to load provinces: ' . $e->getMessage());
        }
    }

    // Search reports based on button click
    public function searchReports()
    {
        $query = Report::query();

        // Search by type or description
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('type', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by selected province
        if ($this->selectedProvince) {
            $query->where('province', $this->selectedProvince);
        }

        // Update reports based on filters
        $this->reports = $query->get();
    }

    // Reset search filters
    public function resetFilters()
    {
        $this->search = ''; // Reset search query
        $this->selectedProvince = ''; // Reset selected province
        $this->reports = Report::all(); // Reset to all reports
    }

    public function render()
    {
        return view('livewire.reports.article-reports', [
            'provinces' => $this->provinces, // Pass provinces to view
            'reports' => $this->reports, // Pass reports to view
        ]);
    } 
}
