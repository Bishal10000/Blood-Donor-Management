<?php

namespace App\Http\Controllers;

use App\Http\Requests\Donor\StoreDonorRequest;
use App\Models\Donor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DonorController extends Controller
{
    public function create(): View
    {
        return view('donor.create');
    }

    public function store(StoreDonorRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Donor::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'blood_group' => $validated['blood_group'],
            'province' => $validated['province'],
            'district' => $validated['district'],
            'is_active' => true,
        ]);

        return redirect()->route('dashboard.user')->with('status', 'Donor registered successfully.');
    }
}
