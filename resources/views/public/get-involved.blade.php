@extends('layouts.app')

@section('title', 'Get Involved')

@push('styles')
<link rel="stylesheet" href="{{ asset('legacy/style/why.css') }}">
@endpush

@section('content')
<section class="main-section">
    <div class="container">
        <h1>Get Involved</h1>
        <p>Register as donor, spread awareness, and help connect urgent blood requests with active donors.</p>
        <p><a href="{{ route('register.form') }}" class="donate-button">Join Now</a></p>
    </div>
</section>
@endsection
