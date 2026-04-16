<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Donor;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function requests(): View
    {
        $requests = BloodRequest::query()
            ->where('user_id', auth()->id())
            ->latest('requested_at')
            ->latest('id')
            ->get();

        return view('history.requests', [
            'requests' => $requests,
        ]);
    }

    public function donations(): View
    {
        $donations = Donor::query()
            ->where('user_id', auth()->id())
            ->latest('id')
            ->get();

        return view('history.donations', [
            'donations' => $donations,
        ]);
    }
}
