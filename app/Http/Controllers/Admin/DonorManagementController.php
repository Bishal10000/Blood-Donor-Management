<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\DonorNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonorManagementController extends Controller
{
    public function index(): View
    {
        return view('admin.donors.index', [
            'donors' => Donor::query()->latest()->get(),
        ]);
    }

    public function edit(Donor $donor): View
    {
        return view('admin.donors.edit', [
            'donor' => $donor,
        ]);
    }

    public function update(Request $request, Donor $donor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'district' => ['required', 'string', 'max:255'],
        ]);

        $donor->update($validated);

        return redirect()->route('admin.donors.index')->with('status', 'Donor updated successfully.');
    }

    public function destroy(Donor $donor): RedirectResponse
    {
        $donor->delete();

        return back()->with('status', 'Donor deleted successfully.');
    }

    public function verify(Donor $donor): RedirectResponse
    {
        $localMatches = BloodRequest::query()
            ->where('blood_group', $donor->blood_group)
            ->where('district', $donor->district)
            ->limit(3)
            ->pluck('phone')
            ->all();

        $message = 'No blood requests found for your donation (' . $donor->blood_group . ').';

        if (! empty($localMatches)) {
            $message = 'Potential blood receivers found for your donation (' . $donor->blood_group . '). Receiver contacts: ' . implode(', ', $localMatches);
        } else {
            $anyMatches = BloodRequest::query()
                ->where('blood_group', $donor->blood_group)
                ->limit(2)
                ->pluck('phone')
                ->all();

            if (! empty($anyMatches)) {
                $message = 'No local blood requests found, but potential receivers for your donation (' . $donor->blood_group . ') are: ' . implode(', ', $anyMatches);
            }
        }

        DonorNotification::create([
            'donor_id' => $donor->id,
            'donor_email' => $donor->email,
            'message' => $message,
            'status' => 'unread',
        ]);

        return back()->with('status', $message);
    }
}
