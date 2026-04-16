@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="card">
    <h1>Admin Dashboard</h1>
    <p class="muted mt-6">Control approvals, inventory, and platform users from one place.</p>

    <div class="metric-grid mt-14">
        <div class="metric-card">
            <div class="metric-label">Total Users</div>
            <div class="metric-value">{{ $totalUsers }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Total Donors</div>
            <div class="metric-value">{{ $totalDonors }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Total Requests</div>
            <div class="metric-value">{{ $totalRequests }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Pending Requests</div>
            <div class="metric-value">{{ $pendingRequests }}</div>
        </div>
    </div>

    <div class="actions-row mt-14">
        <a class="btn primary" href="{{ route('admin.requests.pending') }}">Pending Requests</a>
        <a class="btn" href="{{ route('admin.inventory.index') }}">Blood Inventory</a>
        <a class="btn" href="{{ route('admin.donors.index') }}">Manage Donors</a>
        <a class="btn" href="{{ route('admin.receivers.index') }}">Manage Receivers</a>
        <a class="btn" href="{{ route('admin.users.index') }}">Manage Users</a>
    </div>
</div>
@endsection
