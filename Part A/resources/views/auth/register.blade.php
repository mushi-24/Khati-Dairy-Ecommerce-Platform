@extends('layouts.app')
@section('title', 'Sign up — Khati Dairy')
@section('content')
<div class="auth-box">
    <div class="card">
        <div class="text-center mb-2">
            <h2 style="margin:0;color:var(--green)">Create customer account</h2>
            <p class="muted">Shop fresh dairy with Cash on Delivery</p>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Full name</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <button class="btn btn-block" type="submit">Create account</button>
        </form>
        <p class="text-center muted mt-2">Already registered? <a href="{{ route('login') }}">Login</a></p>
    </div>
</div>
@endsection
