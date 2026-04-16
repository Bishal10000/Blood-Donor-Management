<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function userDashboard(): View
    {
        $activeRole = session('active_role');

        abort_unless(in_array($activeRole, ['donor', 'receiver'], true), 403, 'Access denied.');

        return view('dashboard.user', [
            'activeRole' => $activeRole,
        ]);
    }

    public function adminDashboard(): View
    {
        return view('dashboard.admin');
    }
}
