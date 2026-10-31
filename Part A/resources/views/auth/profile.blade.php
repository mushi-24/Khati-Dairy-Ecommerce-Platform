@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
<div class="auth-box">
    <div class="card">
        <h2 style="margin-top:0;color:var(--green)">Edit profile</h2>
        <p class="muted">Update name, phone, email or password ({{ $user->role }})</p>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Full name</label>
                <input id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
            </div>
            <hr style="border:none;border-top:1px solid var(--border);margin:16px 0">
            <p class="muted">Leave password blank to keep current password.</p>
            <div class="form-group">
                <label for="password">New password</label>
                <input id="password" type="password" name="password" minlength="8" autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm new password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
            </div>
            <button class="btn btn-block" type="submit">Save changes</button>
        </form>
        @if($user->role === 'employee')
            <p class="text-center mt-2"><a href="{{ route('employee.profile') }}">View employee HR profile →</a></p>
        @endif
    </div>
</div>
@endsection
