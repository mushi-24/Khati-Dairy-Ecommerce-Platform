@extends('layouts.app')
@section('title', 'Forgot Password')
@section('content')
<div class="auth-box">
    <div class="card">
        <h2 style="margin-top:0;color:var(--green)">Reset password</h2>
        <p class="muted">Enter your account email and a new password.</p>
        <form method="POST" action="{{ route('password.reset') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">New password</label>
                <input id="password" type="password" name="password" required minlength="8">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <button class="btn btn-block" type="submit">Update password</button>
        </form>
        <p class="text-center muted mt-2"><a href="{{ route('login') }}">Back to login</a></p>
    </div>
</div>
@endsection
