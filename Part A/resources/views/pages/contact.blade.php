@extends('layouts.app')
@section('title', 'Contact — Khati Dairy')
@section('content')
<div class="card" style="max-width:520px;margin:0 auto;padding:28px">
    <h1 style="color:var(--green);margin-top:0">Contact Us</h1>
    <p class="muted">We are happy to help with orders and shop partnerships.</p>
    <p><strong>Helpline:</strong> +8801766411559</p>
    <p><strong>Email:</strong> admin@khatidairy.com</p>
    <p><strong>Hours:</strong> 8:00 AM – 10:00 PM</p>
    <form class="mt-2" onsubmit="event.preventDefault();alert('Demo contact form — connect mail in production.');">
        <div class="form-group"><label>Your name</label><input required></div>
        <div class="form-group"><label>Message</label><textarea rows="4" required></textarea></div>
        <button class="btn" type="submit">Send message</button>
    </form>
</div>
@endsection
