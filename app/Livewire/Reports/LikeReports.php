<?php

namespace App\Livewire\Reports;

use App\Models\Report;
use Livewire\Component;

class LikeReports extends Component
{
    public $report;
    public $liked = false;

    public function mount(Report $report)
    {
        $this->report = $report;

        // Check if the user has already liked the report by checking if their ID is in the 'voting' array
        $this->liked = in_array(auth()->user()->id, $this->report->voting);
    }

    public function toggleLike()
    {
        $userId = auth()->user()->id;
        $voting = $this->report->voting ?? []; // If 'voting' is null, treat it as an empty array

        if (!$this->liked) {
            // Add the user's ID to the 'voting' array
            $voting[] = $userId;
            $this->report->voting = $voting; // Update the 'voting' field
            $this->liked = true;
        } else {
            // Remove the user's ID from the 'voting' array
            $voting = array_filter($voting, fn($id) => $id != $userId);
            $this->report->voting = array_values($voting); // Re-index the array
            $this->liked = false;
        }

        // Save the updated report
        $this->report->save();

        // Emit the event to update the like count in the parent component
        $this->dispatch('likeUpdated', $this->report->id, count($this->report->voting)); // Update the like count
    }
    public function render()
    {
        return view('livewire.reports.like-reports');
    }
}
