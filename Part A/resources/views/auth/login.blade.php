@extends('layouts.app')
@section('title', 'Login — Khati Dairy')
@section('content')
<div class="auth-box">
    <div class="card">
        <div class="text-center mb-2">
            <div class="logo-mark" style="margin:0 auto 10px">KD</div>
            <h2 style="margin:0;color:var(--green)">Welcome back</h2>
            <p class="muted">Login to order or manage the dashboard</p>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            <label style="display:flex;align-items:center;gap:8px;font-weight:500;margin-bottom:14px">
                <input type="checkbox" name="remember" style="width:auto"> Remember me
            </label>
            <p style="text-align:right;margin:0 0 12px"><a href="{{ route('password.request') }}">Forgot password?</a></p>
            <button class="btn btn-block" type="submit">Login</button>
        </form>
        <p class="text-center muted mt-2">No account? <a href="{{ route('register') }}">Sign up</a></p>
    </div>
</div>
@endsection
