@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="card">
    <h1>Welcome to Your Dashboard</h1>
    <p class="muted">Active role: <strong>{{ ucfirst($activeRole) }}</strong></p>
    <p class="muted">Manage your blood donation and request journey with quick actions below.</p>

    <div class="grid two mt-16">
        <div class="card">
            <h2>Donate Blood</h2>
            <p>Your donation can save lives. Join the cause today.</p>
            <a class="btn primary" href="{{ route('donor.create') }}">Donate Blood</a>
        </div>
        <div class="card">
            <h2>Need Blood?</h2>
            <p>Facing an emergency? Request blood from verified donors.</p>
            <a class="btn primary" href="{{ route('requests.create') }}">Request Blood</a>
        </div>
    </div>

    <div class="actions-row mt-16">
        <a class="btn" href="{{ route('notifications.index') }}">Receiver Notifications</a>
        <a class="btn" href="{{ route('donor.notifications.index') }}">Donor Notifications</a>
        <a class="btn" href="{{ route('history.requests') }}">Request History</a>
        <a class="btn" href="{{ route('history.donations') }}">Donation History</a>
    </div>
</div>
@endsection
