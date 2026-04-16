@extends('layouts.app')

@section('title', 'Edit Donor')

@section('content')
<div class="card">
    <h1>Edit Donor</h1>
    <form method="POST" action="{{ route('admin.donors.update', $donor) }}" class="grid two">
        @csrf
        @method('PATCH')
        <div class="field"><label>Name</label><input name="name" value="{{ old('name', $donor->name) }}" required></div>
        <div class="field"><label>Phone</label><input name="phone" value="{{ old('phone', $donor->phone) }}" required></div>
        <div class="field"><label>Email</label><input name="email" value="{{ old('email', $donor->email) }}"></div>
        <div class="field"><label>Blood Group</label><input name="blood_group" value="{{ old('blood_group', $donor->blood_group) }}" required></div>
        <div class="field"><label>District</label><input name="district" value="{{ old('district', $donor->district) }}" required></div>
        <div class="field align-end"><button class="btn primary" type="submit">Update Donor</button></div>
    </form>
</div>
@endsection
