<?php

namespace App\Http\Controllers;

use App\Models\BloodAvailability;
use App\Models\Donor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BloodAvailabilityController extends Controller
{
    public function index(Request $request): View
    {
        $results = collect();
        $filters = [
            'province' => (string) $request->query('province', ''),
            'district' => (string) $request->query('district', ''),
            'blood_group' => (string) $request->query('blood_group', ''),
        ];
        $hasSearch = $filters['province'] !== '' || $filters['district'] !== '' || $filters['blood_group'] !== '';

        if ($hasSearch) {
            $validated = $request->validate([
                'province' => ['required', 'string', 'max:255'],
                'district' => ['required', 'string', 'max:255'],
                'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            ]);

            $results = Donor::query()
                ->where('province', $validated['province'])
                ->where('district', 'like', '%' . $validated['district'] . '%')
                ->where('blood_group', $validated['blood_group'])
                ->where('is_active', true)
                ->get();
        }

        return view('availability.index', [
            'results' => $results,
            'filters' => $filters,
            'hasSearch' => $hasSearch,
        ]);
    }

    public function search(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'province' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
        ]);

        return redirect()->route('availability.index', $validated);
    }

    public function searchLocation(Request $request)
    {
        $validated = $request->validate([
            'district' => ['required', 'string', 'max:255'],
            'municipality' => ['required', 'string', 'max:255'],
        ]);

        $data = BloodAvailability::query()
            ->where('district', $validated['district'])
            ->where('municipality', $validated['municipality'])
            ->get(['health_post', 'address', 'blood_group', 'available_units', 'contact']);

        return response()->json($data);
    }
}
