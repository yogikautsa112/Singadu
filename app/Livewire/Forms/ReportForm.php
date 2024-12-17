<?php

namespace App\Livewire\Forms;

use App\Models\Report;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Form;

class ReportForm extends Form
{
    //
    use WithFileUploads;
    public ?Report $report;

    #[Validate('required', as: 'Province')]
    public $province;

    #[Validate('required', as: 'Regency')]
    public $regency;

    #[Validate('required', as: 'Subdistrict')]
    public $subdistrict;

    #[Validate('required', as: 'Village')]
    public $village;

    #[Validate('required|in:KEJAHATAN,PEMBANGUNAN,SOSIAL')]
    public $type;

    #[Validate('required|string')]
    public $description;

    #[Validate('required|image|max:2048')]
    public $image;

    public function store()
    {
        $this->validate();

        // Get full names instead of IDs
        $provinceFullName = $this->getFullName($this->province, 'provinces');
        $regencyFullName = $this->getFullName($this->regency, 'regencies');
        $subdistrictFullName = $this->getFullName($this->subdistrict, 'districts');
        $villageFullName = $this->getFullName($this->village, 'villages');

        if ($this->image) {
            $imagePath = $this->image->storeAs('reports/images', 'public');
        } else {
            throw new \Exception('Image is required');
        }
    

        $report = Report::create([
            'user_id' => auth()->id(),
            'province' => $provinceFullName,
            'regency' => $regencyFullName,
            'subdistrict' => $subdistrictFullName,
            'village' => $villageFullName,
            'type' => $this->type,
            'description' => $this->description,
            'voting' => [], 
            'views' => 0,
            'statement' => false,
            'image' => $imagePath,
        ]);
        dd($report);

        return $report;
    }

    private function getFullName($id, $type)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/{$type}.json");
            $data = $response->json();
            
            $item = collect($data)->firstWhere('id', $id);
            
            return $item ? $item['name'] : $id;
        } catch (\Exception $e) {
            return $id;
        }
    }
}
