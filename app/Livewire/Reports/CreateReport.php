<?php

namespace App\Livewire\Reports;

use App\Models\Report;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Masmerise\Toaster\Toaster;

class CreateReport extends Component
{
    use WithFileUploads;

    public $province = '';
    public $regency = '';
    public $subdistrict = '';
    public $village = '';
    public $type = '';
    public $description = '';
    public $image = null;
    public $statement = false;
    public $loading = false;

    public $provinces = [];
    public $regencies = [];
    public $districts = [];
    public $villages = [];

    protected $rules = [
        'province' => 'required',
        'regency' => 'required',
        'subdistrict' => 'required',
        'village' => 'required',
        'type' => 'required|in:KEJAHATAN,PEMBANGUNAN,SOSIAL',
        'description' => 'required|min:10',
        'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        'statement' => 'required|accepted'
    ];

    public function mount()
    {
        $this->fetchProvinces();
    }

    public function fetchProvinces()
    {
        try {
            $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
            $this->provinces = $response->json();
        } catch (\Exception $e) {
            $this->provinces = [];
            session()->flash('error', 'Failed to load provinces: ' . $e->getMessage());
        }
    }

    public function updatedProvince($provinceId)
    {
        $this->reset(['regency', 'subdistrict', 'village', 'regencies', 'districts', 'villages']);

        if ($provinceId) {
            try {
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
                $this->regencies = $response->json();
            } catch (\Exception $e) {
                $this->regencies = [];
                session()->flash('error', 'Failed to load regencies: ' . $e->getMessage());
            }
        }
    }

    public function updatedRegency($regencyId)
    {
        $this->reset(['subdistrict', 'village', 'districts', 'villages']);

        if ($regencyId) {
            try {
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$regencyId}.json");
                $this->districts = $response->json();
            } catch (\Exception $e) {
                $this->districts = [];
                session()->flash('error', 'Failed to load districts: ' . $e->getMessage());
            }
        }
    }

    public function updatedSubdistrict($districtId)
    {
        $this->reset(['village', 'villages']);

        if ($districtId) {
            try {
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$districtId}.json");
                $this->villages = $response->json();
            } catch (\Exception $e) {
                $this->villages = [];
                session()->flash('error', 'Failed to load villages: ' . $e->getMessage());
            }
        }
    }

    public function saveReport()
    {
        $this->loading = true;
        $this->validate();

        try {
            // Validate and store image
            if (!$this->image) {
                throw new \Exception('Image is required');
            }

            $imagePath = $this->image->store('reports', 'public');

            // Find the full names directly from the current selections
            $provinceName = collect($this->provinces)->firstWhere('id', $this->province)['name'] ?? $this->province;
            $regencyName = collect($this->regencies)->firstWhere('id', $this->regency)['name'] ?? $this->regency;
            $subdistrictName = collect($this->districts)->firstWhere('id', $this->subdistrict)['name'] ?? $this->subdistrict;
            $villageName = collect($this->villages)->firstWhere('id', $this->village)['name'] ?? $this->village;

            // Create report
            $report = Report::create([
                'user_id' => auth()->id(),
                'province' => $provinceName,
                'regency' => $regencyName,
                'subdistrict' => $subdistrictName,
                'village' => $villageName,
                'type' => $this->type,
                'description' => $this->description,
                'voting' => [],
                'views' => 0,
                'image' => $imagePath,
                'statement' => $this->statement,
            ]);

            // Reset the form fields
            $this->reset([
                'province',
                'regency',
                'subdistrict',
                'village',
                'type',
                'description',
                'image',
                'statement'
            ]);

            // Flash success message and redirect
            Toaster::success('Keluhan Telah Berhasil Dibuat!');
            return redirect()->route('reports.index');
        } catch (\Exception $e) {
            session()->flash('Failed to submit report: ' . $e->getMessage());
        } finally {
            $this->loading = false;
        }
    }


    private function getFullName($id, $type)
    {
        try {
            $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/{$type}.json");
            $data = $response->json();

            $item = collect($data)->firstWhere('id', $id);

            return $item ? $item['name'] : $id;
        } catch (\Exception $e) {
            return $id;
        }
    }

    public function render()
    {
        return view('livewire.reports.create-report', [
            'reportTypes' => [
                'KEJAHATAN' => 'Kejahatan',
                'PEMBANGUNAN' => 'Pembangunan',
                'SOSIAL' => 'Sosial'
            ]
        ]);
    }
}
