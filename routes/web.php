<?php

use App\Http\Controllers\Admin\BloodInventoryController;
use App\Http\Controllers\Admin\BloodRequestApprovalController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DonorManagementController;
use App\Http\Controllers\Admin\ReceiverManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BloodAvailabilityController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorNotificationController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InfoPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/why-bdms', [InfoPageController::class, 'whyBdms'])->name('why.bdms');
Route::get('/get-involved', [InfoPageController::class, 'getInvolved'])->name('get.involved');
Route::get('/looking-for-blood', [InfoPageController::class, 'lookingForBlood'])->name('looking.for.blood');
Route::get('/our-achievements', [InfoPageController::class, 'achievements'])->name('our.achievements');

Route::middleware('guest')->group(function (): void {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

Route::get('/availability', [BloodAvailabilityController::class, 'index'])->name('availability.index');
Route::post('/availability/search', [BloodAvailabilityController::class, 'search'])->name('availability.search');
Route::post('/api/inventory/search-location', [BloodAvailabilityController::class, 'searchLocation'])
    ->name('availability.location.search');

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])
        ->middleware('role:donor,receiver')
        ->name('dashboard.user');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('role:admin')
        ->name('dashboard.admin');

    Route::middleware('role:admin')->group(function (): void {
        Route::get('/admin/requests/pending', [BloodRequestApprovalController::class, 'index'])
            ->name('admin.requests.pending');
        Route::patch('/admin/requests/{bloodRequest}/approve', [BloodRequestApprovalController::class, 'approve'])
            ->name('admin.requests.approve');
        Route::patch('/admin/requests/{bloodRequest}/reject', [BloodRequestApprovalController::class, 'reject'])
            ->name('admin.requests.reject');

        Route::get('/admin/inventory', [BloodInventoryController::class, 'index'])
            ->name('admin.inventory.index');
        Route::post('/admin/inventory', [BloodInventoryController::class, 'store'])
            ->name('admin.inventory.store');
        Route::patch('/admin/inventory/{bloodAvailability}', [BloodInventoryController::class, 'update'])
            ->name('admin.inventory.update');
        Route::delete('/admin/inventory/{bloodAvailability}', [BloodInventoryController::class, 'destroy'])
            ->name('admin.inventory.destroy');

        Route::get('/admin/donors', [DonorManagementController::class, 'index'])->name('admin.donors.index');
        Route::get('/admin/donors/{donor}/edit', [DonorManagementController::class, 'edit'])->name('admin.donors.edit');
        Route::patch('/admin/donors/{donor}', [DonorManagementController::class, 'update'])->name('admin.donors.update');
        Route::delete('/admin/donors/{donor}', [DonorManagementController::class, 'destroy'])->name('admin.donors.destroy');
        Route::post('/admin/donors/{donor}/verify', [DonorManagementController::class, 'verify'])->name('admin.donors.verify');

        Route::get('/admin/receivers', [ReceiverManagementController::class, 'index'])->name('admin.receivers.index');
        Route::get('/admin/receivers/{bloodRequest}/edit', [ReceiverManagementController::class, 'edit'])->name('admin.receivers.edit');
        Route::patch('/admin/receivers/{bloodRequest}', [ReceiverManagementController::class, 'update'])->name('admin.receivers.update');
        Route::delete('/admin/receivers/{bloodRequest}', [ReceiverManagementController::class, 'destroy'])->name('admin.receivers.destroy');
        Route::post('/admin/receivers/{bloodRequest}/verify', [ReceiverManagementController::class, 'verify'])->name('admin.receivers.verify');

        Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::patch('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::middleware('role:donor,receiver')->group(function (): void {
        Route::get('/donor/register', [DonorController::class, 'create'])->name('donor.create');
        Route::post('/donor/register', [DonorController::class, 'store'])->name('donor.store');

        Route::get('/receiver/request', [BloodRequestController::class, 'create'])->name('requests.create');
        Route::post('/receiver/request', [BloodRequestController::class, 'store'])->name('requests.store');

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])
            ->name('notifications.read');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
            ->name('notifications.destroy');

        Route::get('/donor/notifications', [DonorNotificationController::class, 'index'])
            ->name('donor.notifications.index');
        Route::patch('/donor/notifications/{notification}/read', [DonorNotificationController::class, 'markRead'])
            ->name('donor.notifications.read');
        Route::delete('/donor/notifications/{notification}', [DonorNotificationController::class, 'destroy'])
            ->name('donor.notifications.destroy');

        Route::get('/history/requests', [HistoryController::class, 'requests'])->name('history.requests');
        Route::get('/history/donations', [HistoryController::class, 'donations'])->name('history.donations');
    });
});
