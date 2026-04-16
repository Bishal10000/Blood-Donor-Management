<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class InfoPageController extends Controller
{
    public function whyBdms(): View
    {
        return view('public.why', [
            'totalRegistrations' => Schema::hasTable('users') ? User::count() : 0,
            'totalDonations' => Schema::hasTable('donors') ? Donor::count() : 0,
        ]);
    }

    public function getInvolved(): View
    {
        return view('public.get-involved');
    }

    public function lookingForBlood(): View
    {
        return view('public.looking-for-blood');
    }

    public function achievements(): View
    {
        $hasDonors = Schema::hasTable('donors');
        $hasRequests = Schema::hasTable('blood_requests');

        $topDonors = $hasDonors ? Donor::query()->latest()->limit(5)->get() : collect();
        $recentRequests = $hasRequests ? BloodRequest::query()->latest()->limit(10)->get() : collect();

        return view('public.achievements', [
            'totalDonors' => $hasDonors ? Donor::count() : 0,
            'totalReceivers' => $hasRequests ? BloodRequest::count() : 0,
            'successfulConnections' => $hasRequests ? BloodRequest::query()->where('status', 'approved')->count() : 0,
            'activeDonors' => $hasDonors ? Donor::query()->where('is_active', true)->count() : 0,
            'topDonors' => $topDonors,
            'recentRequests' => $recentRequests,
        ]);
    }
}
