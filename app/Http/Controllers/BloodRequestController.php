<?php

namespace App\Http\Controllers;

use App\Http\Requests\BloodRequest\StoreBloodRequestRequest;
use App\Models\BloodRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BloodRequestController extends Controller
{
    public function create(): View
    {
        return view('requests.create');
    }

    public function store(StoreBloodRequestRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $filePath = null;
        if ($request->hasFile('requisition')) {
            $filePath = $request->file('requisition')->store('requisitions', 'public');
        }

        BloodRequest::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'],
            'blood_group' => $validated['blood_group'],
            'province' => $validated['province'],
            'district' => $validated['district'],
            'note' => $validated['note'] ?? null,
            'requisition_file' => $filePath,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        return redirect()->route('dashboard.user')->with('status', 'Blood request submitted successfully.');
    }
}
