<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\DonorNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DonorNotificationController extends Controller
{
    public function index(): View
    {
        $donor = Donor::query()->where('user_id', auth()->id())->latest('id')->first();
        abort_if(! $donor, 403, 'You must be a registered donor.');

        $notifications = DonorNotification::query()
            ->where('donor_id', $donor->id)
            ->latest()
            ->get();

        return view('donor.notifications.index', [
            'donor' => $donor,
            'notifications' => $notifications,
        ]);
    }

    public function markRead(DonorNotification $notification): RedirectResponse
    {
        $donor = Donor::query()->where('user_id', auth()->id())->latest('id')->first();
        abort_if(! $donor || $notification->donor_id !== $donor->id, 403);

        $notification->update(['status' => 'read']);

        return back()->with('status', 'Notification marked as read.');
    }

    public function destroy(DonorNotification $notification): RedirectResponse
    {
        $donor = Donor::query()->where('user_id', auth()->id())->latest('id')->first();
        abort_if(! $donor || $notification->donor_id !== $donor->id, 403);

        $notification->delete();

        return back()->with('status', 'Notification deleted successfully.');
    }
}
