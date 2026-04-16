@extends('layouts.app')

@section('title', 'Find Blood Donors')

@section('content')
<div class="card">
    <h1>Find Blood Donors</h1>
    <p class="muted mt-6">Filter by location and blood group to see verified active donors.</p>

    <form method="GET" action="{{ route('availability.index') }}" class="grid two mt-16">
        <div class="field">
            <label for="province">Province</label>
            <select id="province" name="province" required>
                <option value="">Select a Province</option>
                @foreach(['Koshi','Madesh','Bagmati','Gandaki','Lumbini','Karnali','Sudurpashchim'] as $province)
                    <option value="{{ $province }}" @selected(($filters['province'] ?? '') === $province)>{{ $province }}</option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="district">District</label>
            <input id="district" name="district" value="{{ $filters['district'] ?? '' }}" required>
        </div>

        <div class="field">
            <label for="blood_group">Blood Group</label>
            <select id="blood_group" name="blood_group" required>
                <option value="">Select Blood Group</option>
                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $blood)
                    <option value="{{ $blood }}" @selected(($filters['blood_group'] ?? '') === $blood)>{{ $blood }}</option>
                @endforeach
            </select>
        </div>

        <div class="field field-actions">
            <button class="btn primary" type="submit">Search Donors</button>
            <a class="btn" href="{{ route('availability.index') }}">Reset</a>
        </div>
    </form>

    <div class="table-wrap mt-18">
        <table>
            <thead>
                <tr>
                    <th>Donor</th>
                    <th>Blood Group</th>
                    <th>Province</th>
                    <th>District</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $row)
                    <tr>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->blood_group }}</td>
                        <td>{{ $row->province }}</td>
                        <td>{{ $row->district }}</td>
                        <td>
                            @auth
                                {{ $row->phone }}
                            @else
                                <a href="{{ route('register.form') }}">Register</a> or <a href="{{ route('login.form') }}">Login</a> to view contact
                            @endauth
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted">
                            {{ $hasSearch ? 'No donors found matching your criteria. Try nearby districts or another blood group.' : 'Run a search to view available donors.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
