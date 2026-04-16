@extends('layouts.app')

@section('title', 'Our Achievements')

@push('styles')
<link rel="stylesheet" href="{{ asset('legacy/style/achiv.css') }}">
@endpush

@section('content')
<div class="container">
    <h1>Blood Donor Network Achievements</h1>

    <div class="achievement-container">
        <div class="stat-card"><div class="stat-number">{{ $totalDonors }}</div><h3>Registered Donors</h3></div>
        <div class="stat-card"><div class="stat-number">{{ $totalReceivers }}</div><h3>Registered Receivers</h3></div>
        <div class="stat-card"><div class="stat-number">{{ $successfulConnections }}</div><h3>Successful Connections</h3></div>
        <div class="stat-card"><div class="stat-number">{{ $activeDonors }}</div><h3>Currently Active Donors</h3></div>
    </div>

    <div class="list-section">
        <h2>Top Recent Donors</h2>
        <table class="data-table">
            <thead><tr><th>Donor Name</th><th>Blood Group</th><th>Location</th><th>Contact</th></tr></thead>
            <tbody>
                @foreach($topDonors as $donor)
                <tr>
                    <td>{{ $donor->name }}</td>
                    <td>{{ $donor->blood_group }}</td>
                    <td>{{ $donor->district }}</td>
                    <td>@auth{{ $donor->phone }}@else<a href="{{ route('login.form') }}">Login</a> / <a href="{{ route('register.form') }}">Register</a>@endauth</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="list-section">
        <h2>Recent Blood Requests</h2>
        <table class="data-table">
            <thead><tr><th>Requester</th><th>Blood Group</th><th>Location</th><th>Contact</th></tr></thead>
            <tbody>
                @foreach($recentRequests as $request)
                <tr>
                    <td>{{ $request->name }}</td>
                    <td>{{ $request->blood_group }}</td>
                    <td>{{ $request->district }}</td>
                    <td>@auth{{ $request->phone }}@else<a href="{{ route('login.form') }}">Login</a> / <a href="{{ route('register.form') }}">Register</a>@endauth</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
