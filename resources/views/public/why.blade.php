@extends('layouts.app')

@section('title', 'Why BDMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('legacy/style/why.css') }}">
@endpush

@section('content')
<section class="main-section">
    <div class="container">
        <h1>Why BDMS?</h1>
        <p>In emergencies, families struggle to find blood quickly. BDMS helps digitize donor and request workflows to save lives faster.</p>
        <p>Our mission is to make blood access transparent, efficient, and accessible.</p>
    </div>
</section>
<section class="stats-section">
    <div class="container">
        <h2>Our Impact</h2>
        <div class="stats">
            <div class="stat"><h3>Total Registrations</h3><p>{{ $totalRegistrations }}</p></div>
            <div class="stat"><h3>Blood Donations</h3><p>{{ $totalDonations }}</p></div>
        </div>
    </div>
</section>
@endsection
