<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReceiverManagementController extends Controller
{
    public function index(): View
    {
        return view('admin.receivers.index', [
            'requests' => BloodRequest::query()->latest()->get(),
        ]);
    }

    public function edit(BloodRequest $bloodRequest): View
    {
        return view('admin.receivers.edit', [
            'bloodRequest' => $bloodRequest,
        ]);
    }

    public function update(Request $request, BloodRequest $bloodRequest): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        $bloodRequest->update($validated);

        return redirect()->route('admin.receivers.index')->with('status', 'Request updated successfully.');
    }

    public function destroy(BloodRequest $bloodRequest): RedirectResponse
    {
        $bloodRequest->delete();

        return back()->with('status', 'Request deleted successfully.');
    }

    public function verify(BloodRequest $bloodRequest): RedirectResponse
    {
        $localDonors = Donor::query()
            ->where('blood_group', $bloodRequest->blood_group)
            ->where('province', $bloodRequest->province)
            ->where('district', $bloodRequest->district)
            ->where('is_active', true)
            ->limit(3)
            ->pluck('phone')
            ->all();

        $message = 'Blood group not found in inventory for ' . $bloodRequest->name . ' (' . $bloodRequest->blood_group . ').';

        if (! empty($localDonors)) {
            $message = 'We found potential donors for ' . $bloodRequest->name . ' (' . $bloodRequest->blood_group . '). Donor contacts: ' . implode(', ', $localDonors);
        } else {
            $provinceDonors = Donor::query()
                ->where('blood_group', $bloodRequest->blood_group)
                ->where('province', $bloodRequest->province)
                ->where('is_active', true)
                ->limit(2)
                ->pluck('phone')
                ->all();

            if (! empty($provinceDonors)) {
                $message = 'No local donors found for ' . $bloodRequest->name . ', but we found some in ' . $bloodRequest->province . ' province. Contacts: ' . implode(', ', $provinceDonors);
            }
        }

        UserNotification::create([
            'user_id' => $bloodRequest->user_id,
            'user_email' => $bloodRequest->email,
            'message' => $message,
            'status' => 'unread',
        ]);

        return back()->with('status', $message);
    }
}
