@extends('layouts.app')

@section('title', 'Blood Request')

@section('content')
<div class="card">
    <h1>Blood Request Form</h1>

    <form action="{{ route('requests.store') }}" method="POST" enctype="multipart/form-data">
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

        <div class="field">
            <label for="requisition">Requisition Form (PDF/JPG/PNG, max 5MB)</label>
            <input id="requisition" name="requisition" type="file" accept=".pdf,.jpg,.jpeg,.png" required>
            @error('requisition')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="note">Note</label>
            <input id="note" name="note" value="{{ old('note') }}">
            @error('note')<div class="error">{{ $message }}</div>@enderror
        </div>

        <button class="btn primary" type="submit">Submit Request</button>
    </form>
</div>
@endsection
