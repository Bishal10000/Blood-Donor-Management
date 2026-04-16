@extends('layouts.app')

@section('title', 'Edit Receiver Request')

@section('content')
<div class="card">
    <h1>Edit Blood Request</h1>
    <form method="POST" action="{{ route('admin.receivers.update', $bloodRequest) }}" class="grid two">
        @csrf
        @method('PATCH')
        <div class="field"><label>Name</label><input name="name" value="{{ old('name', $bloodRequest->name) }}" required></div>
        <div class="field"><label>Email</label><input name="email" value="{{ old('email', $bloodRequest->email) }}"></div>
        <div class="field"><label>Phone</label><input name="phone" value="{{ old('phone', $bloodRequest->phone) }}" required></div>
        <div class="field"><label>Blood Group</label><input name="blood_group" value="{{ old('blood_group', $bloodRequest->blood_group) }}" required></div>
        <div class="field full"><label>Note</label><input name="note" value="{{ old('note', $bloodRequest->note) }}"></div>
        <div class="field align-end"><button class="btn primary" type="submit">Update Request</button></div>
    </form>
</div>
@endsection
