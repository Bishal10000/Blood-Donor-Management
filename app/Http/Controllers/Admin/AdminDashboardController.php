<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard.admin', [
            'totalUsers' => User::count(),
            'totalDonors' => Donor::count(),
            'totalRequests' => BloodRequest::count(),
            'pendingRequests' => BloodRequest::query()->where('status', 'pending')->count(),
        ]);
    }
}
