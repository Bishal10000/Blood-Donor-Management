@extends('layouts.app')

@section('title', 'Looking For Blood')

@push('styles')
<link rel="stylesheet" href="{{ asset('legacy/style/why.css') }}">
@endpush

@section('content')
<section class="main-section">
    <div class="container">
        <h1>Looking For Blood</h1>
        <p>Search donor availability by district and blood group, then contact matched donors quickly.</p>
        <p><a href="{{ route('availability.index') }}" class="donate-button">Search Donors</a></p>
    </div>
</section>
@endsection
