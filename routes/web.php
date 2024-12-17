<?php

use App\Livewire\HeadStaff\HeadStaffDashboard;
use App\Livewire\HeadStaff\ManageStaff;
use App\Livewire\Reports\CreateReport;
use App\Livewire\Reports\ReportManage;
use App\Livewire\Reports\ReportPage;
use App\Livewire\Reports\ShowReport;
use App\Livewire\Staff\ManageResponse;
use App\Livewire\Staff\StaffDashboard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // Route for '/dashboard', which redirects based on user role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // Redirect based on user role
        if ($user->role == 'head_staff') {
            return redirect()->route('head-staff.dashboard');
        } elseif ($user->role == 'staff') {
            return redirect()->route('staff.dashboard');
        } elseif ($user->role == 'guest') {
            return redirect()->route('reports.index');
        }

        return redirect('/');  // Fallback redirect
    })->name('dashboard'); // This fixes the "Route [dashboard] not defined" issue

    // Routes for 'head_staff' with prefix 'head-staff'
    Route::prefix('head-staff')->middleware('role:head_staff')->group(function () {
        Route::get('/dashboard', HeadStaffDashboard::class)
            ->name('head-staff.dashboard');
        Route::get('/manage', ManageStaff::class)
            ->name('staff.manage');
    });

    // Routes for 'staff' with prefix 'staff'
    Route::prefix('staff')->middleware('role:staff')->group(function () {
        Route::get('/dashboard', StaffDashboard::class)
            ->name('staff.dashboard');
        Route::get('/manage/{report_id}', ManageResponse::class)
            ->name('response.manage');
    });
});

Route::prefix('report')->middleware(['auth'])->group(function () {
    Route::get('/', ReportPage::class)->name('reports.index');
    Route::get('/create', CreateReport::class)->name('report.create');
    Route::get('/{reportId}', ShowReport::class)->name('report.show');
    Route::delete('/{id}', [ReportPage::class, 'destroy'])->name('report.delete');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/reports/manage', ReportManage::class)->name('report.manage');
});
