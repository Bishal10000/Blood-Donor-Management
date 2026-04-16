<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BloodAvailability;
use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $usersTable = Schema::hasTable('users');
        $donorsTable = Schema::hasTable('donors');
        $requestsTable = Schema::hasTable('blood_requests');
        $availabilityTable = Schema::hasTable('blood_availabilities');

        return view('home.index', [
            'totalUsers' => $usersTable ? User::count() : 0,
            'totalDonations' => $donorsTable ? Donor::count() : 0,
            'totalRequests' => $requestsTable ? BloodRequest::count() : 0,
            'availableUnits' => $availabilityTable ? (int) BloodAvailability::sum('available_units') : 0,
        ]);
    }
}
