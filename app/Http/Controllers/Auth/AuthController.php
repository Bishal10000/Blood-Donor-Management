<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $selectedTypes = [];
        foreach ($validated['user_type'] as $type) {
            if ($type === 'both') {
                $selectedTypes[] = 'donor';
                $selectedTypes[] = 'receiver';
                continue;
            }

            $selectedTypes[] = $type;
        }

        $selectedTypes = array_values(array_unique($selectedTypes));

        $user = User::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'blood_type' => $validated['blood_type'],
            'age' => $validated['age'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => implode(',', $selectedTypes),
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('active_role', $selectedTypes[0]);

        return redirect()->route('dashboard.user')->with('status', 'Registration completed successfully.');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $identifier = strtolower(trim($validated['username']));

        $user = User::query()
            ->where(function ($subQuery) use ($identifier): void {
                $subQuery
                    ->whereRaw('LOWER(name) = ?', [$identifier])
                    ->orWhereRaw('LOWER(email) = ?', [$identifier]);
            })
            ->get()
            ->first(function (User $candidate) use ($validated): bool {
                $roles = array_map('trim', explode(',', (string) $candidate->user_type));

                return in_array($validated['user_type'], $roles, true);
            });

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors(['username' => 'Invalid credentials.'])
                ->withInput($request->except('password'));
        }

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('active_role', $validated['user_type']);

        if ($validated['user_type'] === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        return redirect()->route('dashboard.user');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
