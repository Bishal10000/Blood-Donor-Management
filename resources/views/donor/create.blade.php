@extends('layouts.app')

@section('title', 'Donor Registration')

@section('content')
<div class="card">
    <h1>Donor Registration Form</h1>

    <form action="{{ route('donor.store') }}" method="POST">
        @csrf

        <div class="field">
            <label for="name">Full Name</label>
            <input id="name" name="name" value="{{ old('name') }}" required>
            @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="grid two">
            <div class="field">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}">
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field">
            <label for="blood_group">Blood Group</label>
            <select id="blood_group" name="blood_group" required>
                <option value="">Select Blood Group</option>
                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $blood)
                    <option value="{{ $blood }}" @selected(old('blood_group') === $blood)>{{ $blood }}</option>
                @endforeach
            </select>
            @error('blood_group')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="grid two">
            <div class="field">
                <label for="province">Province</label>
                <select id="province" name="province" required>
                    <option value="">Select a Province</option>
                    @foreach(['Koshi','Madesh','Bagmati','Gandaki','Lumbini','Karnali','Sudurpashchim'] as $province)
                        <option value="{{ $province }}" @selected(old('province') === $province)>{{ $province }}</option>
                    @endforeach
                </select>
                @error('province')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="district">District</label>
                <input id="district" name="district" value="{{ old('district') }}" required>
                @error('district')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div>

        <button class="btn primary" type="submit">Register as Donor</button>
    </form>
</div>
@endsection
