@extends('layouts.app')

@section('title', 'Blood Donor Mgmt')

@section('content')
<section class="card home-hero">
    <div>
        <span class="hero-kicker">Emergency Ready Network</span>
        <h1>Faster blood access when every minute matters.</h1>
        <p>Connect donors, receivers, and admins in one streamlined workflow built for urgent response and reliable coordination.</p>
        <div class="hero-actions">
            <a href="{{ route('availability.index') }}" class="btn primary">Find Blood Now</a>
            <a href="{{ route('register.form') }}" class="btn">Become a Donor</a>
        </div>
    </div>
    <div class="hero-media">
        <img src="{{ asset('legacy/images/1.webp') }}" alt="Blood donation campaign">
    </div>
</section>

<section class="metric-grid">
    <div class="metric-card">
        <div class="metric-label">Total Registered Users</div>
        <div class="metric-value">{{ $totalUsers }}</div>
    </div>
    <div class="metric-card">
        <div class="metric-label">Total Donations Made</div>
        <div class="metric-value">{{ $totalDonations }}</div>
    </div>
    <div class="metric-card">
        <div class="metric-label">Total Blood Requests</div>
        <div class="metric-value">{{ $totalRequests }}</div>
    </div>
    <div class="metric-card">
        <div class="metric-label">Available Blood Units</div>
        <div class="metric-value">{{ $availableUnits }}</div>
    </div>
</section>

<section class="quick-actions">
    <a href="{{ route('availability.index') }}" class="quick-action red">Blood Availability Search</a>
    <a href="{{ route('availability.index') }}" class="quick-action blue">Blood Bank Directory</a>
    <a href="{{ auth()->check() ? route('donor.create') : route('login.form') }}" class="quick-action yellow">Blood Donation</a>
    <a href="{{ route('register.form') }}" class="quick-action orange">User Register</a>
    <a href="{{ route('login.form') }}" class="quick-action green">User Login</a>
</section>

<section class="card mt-18">
    <h2 class="section-title">Compatible Blood Type Donors</h2>
    <div class="table-wrap mt-10">
        <table>
            <thead>
                <tr><th>Blood Type</th><th>Donate Blood To</th><th>Receive Blood From</th></tr>
            </thead>
            <tbody>
                <tr><td>A+</td><td>A+, AB+</td><td>A+, A-, O+, O-</td></tr>
                <tr><td>O+</td><td>O+, A+, B+, AB+</td><td>O+, O-</td></tr>
                <tr><td>B+</td><td>B+, AB+</td><td>B+, B-, O+, O-</td></tr>
                <tr><td>AB+</td><td>AB+</td><td>Everyone</td></tr>
                <tr><td>A-</td><td>A+, A-, AB+, AB-</td><td>A-, O-</td></tr>
                <tr><td>O-</td><td>Everyone</td><td>O-</td></tr>
                <tr><td>B-</td><td>B+, B-, AB+, AB-</td><td>B-, O-</td></tr>
                <tr><td>AB-</td><td>AB+, AB-</td><td>AB-, A-, B-, O-</td></tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
