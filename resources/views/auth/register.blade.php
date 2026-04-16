@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="card centered-card max-w-760">
    <h1 class="mt-0">Create an Account</h1>
    <p class="muted mt-6">Register as donor, receiver, or both and access your personalized dashboard.</p>

    <form action="{{ route('register.perform') }}" method="POST" class="grid mt-12">
            @csrf

            <div class="grid two">
                <div class="field">
                    <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label for="address">Address</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" required>
                @error('address')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid two">
                <div class="field">
                    <label for="phone">Phone</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required>
                @error('phone')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label for="age">Age</label>
                <input type="number" name="age" id="age" value="{{ old('age') }}" required>
                @error('age')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid two">
                <div class="field">
                    <label for="blood_type">Blood Type</label>
                    <select name="blood_type" id="blood_type" required>
                        <option value="">Select</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $blood)
                            <option value="{{ $blood }}" @selected(old('blood_type') === $blood)>{{ $blood }}</option>
                        @endforeach
                    </select>
                    @error('blood_type')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid two">
                <div class="field">
                    <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                @error('password')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>
            </div>

            <div class="field">
                <label>User Type</label>
                <div class="choice-group">
                    <label class="choice-option"><input type="radio" name="user_type[]" value="donor" @checked(collect(old('user_type', []))->contains('donor')) required> Donor</label>
                    <label class="choice-option"><input type="radio" name="user_type[]" value="receiver" @checked(collect(old('user_type', []))->contains('receiver'))> Receiver</label>
                    <label class="choice-option"><input type="radio" name="user_type[]" value="both" @checked(collect(old('user_type', []))->contains('both'))> Both</label>
                </div>
                @error('user_type')<div class="error">{{ $message }}</div>@enderror
                @error('user_type.*')<div class="error">{{ $message }}</div>@enderror
            </div>

            <button class="btn primary" type="submit">Register</button>
            <p class="muted muted-inline">Already have an account? <a href="{{ route('login.form') }}">Login</a></p>
    </form>
</div>
@endsection
