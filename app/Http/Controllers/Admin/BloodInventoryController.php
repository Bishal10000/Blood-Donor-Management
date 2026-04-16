<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodAvailability;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BloodInventoryController extends Controller
{
    public function index(): View
    {
        return view('admin.inventory.index', [
            'inventories' => BloodAvailability::query()->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'available_units' => ['required', 'integer', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            'province' => ['nullable', 'string', 'max:255'],
            'municipality' => ['nullable', 'string', 'max:255'],
            'health_post' => ['nullable', 'string', 'max:255'],
        ]);

        BloodAvailability::create($validated);

        return back()->with('status', 'Inventory record added successfully.');
    }

    public function update(Request $request, BloodAvailability $bloodAvailability): RedirectResponse
    {
        $validated = $request->validate([
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'available_units' => ['required', 'integer', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            'province' => ['nullable', 'string', 'max:255'],
            'municipality' => ['nullable', 'string', 'max:255'],
            'health_post' => ['nullable', 'string', 'max:255'],
        ]);

        $bloodAvailability->update($validated);

        return back()->with('status', 'Inventory record updated successfully.');
    }

    public function destroy(BloodAvailability $bloodAvailability): RedirectResponse
    {
        $bloodAvailability->delete();

        return back()->with('status', 'Inventory record deleted successfully.');
    }
}
