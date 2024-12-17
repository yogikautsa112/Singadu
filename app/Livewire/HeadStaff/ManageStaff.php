<?php

namespace App\Livewire\HeadStaff;

use App\Models\User;
use Flasher\Laravel\Facade\Flasher;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageStaff extends Component
{
    public $name, $email, $password;
    public $staffs;

    public function mount()
    {
        $this->staffs = User::where('role', 'staff')->get();
    }

    public function addStaff()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // Create the new staff user
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password), // Default password from the first 4 characters of the email
            'role' => 'staff', // Assign the 'staff' role
        ]);

        Toaster::success('User created successfully.');
        $this->resetFields(); // Reset the form fields
        $this->staffs = User::where('role', 'staff')->get(); // Refresh the staff list
    }

    public function deleteStaff($staffId)
    {
        $staff = User::find($staffId);

        if ($staff) {
            $hasResponses = $staff->reports()->whereHas('response')->exists();

            if (!$hasResponses) {
                $staff->delete();
                Toaster::success('Staff deleted successfully.');
                $this->staffs = User::where('role', 'staff')->get(); // Refresh staff list
            } else {
                // If there are responses, show an error message
                Flasher()->error('Staff cannot be deleted as they have associated responses.');
            }
        }
    }


    public function resetPassword($staffId)
    {
        $staff = User::find($staffId);

        if ($staff) {
            // Reset password to the first 4 characters of the email
            $newPassword = substr($staff->email, 0, 4);
            $staff->password = bcrypt($newPassword);
            $staff->save();

            Toaster::success('Password reset successfully.');
        }
    }
    public function render()
    {
        return view('livewire.head-staff.manage-staff');
    }

    private function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = ''; // Reset password field
    }
}
