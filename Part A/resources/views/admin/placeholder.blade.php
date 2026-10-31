@extends('layouts.app')
@section('title', $title)
@section('content')
<a href="{{ route('admin.dashboard') }}">← Dashboard</a>
<div class="card" style="margin-top:12px">
    <h1>{{ $title }}</h1>
    <p class="muted">Module scaffold ready. Tables/migrations exist. Extend controllers for full CRUD per BAUST proposal.</p>
    <p>Logged in as <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->role }}).</p>
</div>
@endsection
