<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BloodRequestApprovalController extends Controller
{
    public function index(): View
    {
        $requests = BloodRequest::query()
            ->where('status', 'pending')
            ->latest('requested_at')
            ->latest('id')
            ->get();

        return view('admin.requests.pending', [
            'requests' => $requests,
        ]);
    }

    public function approve(BloodRequest $bloodRequest): RedirectResponse
    {
        $bloodRequest->update(['status' => 'approved']);

        return back()->with('status', 'Request approved successfully.');
    }

    public function reject(BloodRequest $bloodRequest): RedirectResponse
    {
        $bloodRequest->update(['status' => 'rejected']);

        return back()->with('status', 'Request rejected successfully.');
    }
}
