<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Khati Dairy</title>
    <link rel="stylesheet" href="{{ asset('css/khati.css') }}">
    <style>
        .admin-shell { display: flex; min-height: 100vh; }
        .admin-side {
            width: 260px; background: var(--green); color: #fff;
            flex-shrink: 0; padding: 16px 12px; position: sticky; top: 0; height: 100vh; overflow-y: auto;
        }
        .admin-side a {
            display: block; color: rgba(255,255,255,.88); padding: 10px 12px; border-radius: 10px;
            font-size: 13px; font-weight: 600; margin-bottom: 2px;
        }
        .admin-side a:hover, .admin-side a.active { background: rgba(255,255,255,.12); color: #fff; }
        .admin-side .side-title { font-size: 11px; text-transform: uppercase; letter-spacing: .06em; opacity: .55; margin: 14px 12px 6px; }
        .admin-main { flex: 1; min-width: 0; background: var(--cream); }
        .admin-top {
            background: #fff; border-bottom: 1px solid var(--border);
            padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;
        }
        .admin-body { padding: 20px; }
        .admin-menu-btn { display: none; }
        @media (max-width: 900px) {
            .admin-side {
                position: fixed; left: -280px; z-index: 100; transition: left .2s;
            }
            .admin-side.open { left: 0; box-shadow: 8px 0 30px rgba(0,0,0,.25); }
            .admin-menu-btn { display: inline-flex; }
        }
        .stat-grid { display: grid; gap: 14px; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
        .stat-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 16px; }
        .stat-card .label { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
        .stat-card .value { font-size: 1.4rem; font-weight: 800; color: var(--green); margin-top: 4px; }
    </style>
</head>
<body>
@php $u = auth()->user(); @endphp
<div class="admin-shell">
    <aside class="admin-side" id="adminSide">
        <a href="{{ route('admin.dashboard') }}" style="font-size:15px;margin-bottom:12px">🥛 Khati Admin</a>
        <div class="side-title">Overview</div>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.sales.index') }}">Sales & Reports</a>
        <div class="side-title">Catalog</div>
        <a href="{{ route('admin.products.index') }}">Products</a>
        <a href="{{ route('admin.categories.index') }}">Categories</a>
        <a href="{{ route('admin.shops.index') }}">Shops</a>
        <div class="side-title">Orders</div>
        <a href="{{ route('admin.orders.index') }}">All Orders</a>
        <div class="side-title">Farm & Stock</div>
        <a href="{{ route('admin.production.index') }}">Production</a>
        <a href="{{ route('admin.distribution.index') }}">Distribution</a>
        <a href="{{ route('admin.inventory.index') }}">Inventory</a>
        <div class="side-title">People</div>
        <a href="{{ route('admin.users.index') }}">Users & Roles</a>
        <a href="{{ route('admin.employees.index') }}">Employees</a>
        <a href="{{ route('admin.attendance.index') }}">Attendance</a>
        <a href="{{ route('admin.salary.index') }}">Salaries</a>
        <div class="side-title">Storefront</div>
        <a href="{{ route('home') }}">← View website</a>
        <form action="{{ route('logout') }}" method="POST" style="margin-top:12px;padding:0 8px">@csrf
            <button class="btn btn-sm" type="submit" style="width:100%;background:rgba(255,255,255,.15)">Logout</button>
        </form>
    </aside>
    <div class="admin-main">
        <div class="admin-top">
            <div class="flex">
                <button type="button" class="btn btn-sm btn-outline admin-menu-btn" id="adminMenuBtn">☰ Menu</button>
                <strong>@yield('title', 'Dashboard')</strong>
            </div>
            <span class="muted">{{ $u->name ?? '' }} · {{ $u->role ?? '' }}</span>
        </div>
        <div class="admin-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
            @if(isset($errors) && $errors->any())
                <div class="alert alert-error"><ul style="margin:0;padding-left:18px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            @yield('content')
        </div>
    </div>
</div>
<script>
document.getElementById('adminMenuBtn')?.addEventListener('click', () => {
    document.getElementById('adminSide').classList.toggle('open');
});
</script>
</body>
</html>
