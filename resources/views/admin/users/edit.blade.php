@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="card">
    <h1>Edit User</h1>
    <form method="POST" action="{{ route('admin.users.update', $managedUser) }}" class="grid two">
        @csrf
        @method('PATCH')
        <div class="field"><label>Name</label><input name="name" value="{{ old('name', $managedUser->name) }}" required></div>
        <div class="field"><label>Blood Type</label><input name="blood_type" value="{{ old('blood_type', $managedUser->blood_type) }}"></div>
        <div class="field"><label>Phone</label><input name="phone" value="{{ old('phone', $managedUser->phone) }}"></div>
        <div class="field"><label>Email</label><input name="email" value="{{ old('email', $managedUser->email) }}" required></div>
        <div class="field"><label>Address</label><input name="address" value="{{ old('address', $managedUser->address) }}"></div>
        <div class="field"><label>Age</label><input type="number" name="age" value="{{ old('age', $managedUser->age) }}"></div>
        <div class="field full"><label>User Type</label><input name="user_type" value="{{ old('user_type', $managedUser->user_type) }}" required></div>
        <div class="field align-end"><button class="btn primary" type="submit">Update User</button></div>
    </form>
</div>
@endsection
