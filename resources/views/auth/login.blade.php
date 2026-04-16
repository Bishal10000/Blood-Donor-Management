@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="card centered-card max-w-520">
    <h1 class="mt-0">Welcome Back</h1>
    <p class="muted mt-6">Sign in with your username or email and choose your active role.</p>

    <form action="{{ route('login.perform') }}" method="POST" class="grid mt-14">
        @csrf

        <div class="field">
            <label for="username">Username or Email</label>
            <input id="username" name="username" value="{{ old('username') }}" placeholder="Enter username or email" required>
            @error('username')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <div class="password-wrapper">
                <input id="password" name="password" type="password" required>
                <button type="button" class="btn password-toggle" onclick="togglePassword('password', this)">Show</button>
            </div>
            @error('password')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label>User Type</label>
            <div class="choice-group">
                <label class="choice-option"><input type="radio" name="user_type" value="admin" @checked(old('user_type')==='admin') required> Admin</label>
                <label class="choice-option"><input type="radio" name="user_type" value="donor" @checked(old('user_type')==='donor')> Donor</label>
                <label class="choice-option"><input type="radio" name="user_type" value="receiver" @checked(old('user_type')==='receiver')> Receiver</label>
            </div>
            @error('user_type')<div class="error">{{ $message }}</div>@enderror
        </div>

        <button class="btn primary" type="submit">Login</button>
        <p class="muted muted-inline">Do not have an account? <a href="{{ route('register.form') }}">Sign up</a></p>
    </form>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(fieldId, toggle) {
    const input = document.getElementById(fieldId);
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        toggle.textContent = 'Hide';
    } else {
        input.type = 'password';
        toggle.textContent = 'Show';
    }
}
</script>
@endpush
