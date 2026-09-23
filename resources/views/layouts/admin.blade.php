<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản trị') · Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-account.css') }}">
</head>
<body class="admin-body">
<aside class="sidebar">
    <a class="admin-brand" href="{{ route('admin.dashboard') }}"><span>HL</span><div>Portfolio<small>Control room</small></div></a>
    <nav>
        <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i>⌂</i> Tổng quan</a>
        <a class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}" href="{{ route('admin.profile.edit') }}"><i>◎</i> Thông tin cá nhân</a>
        <a class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}"><i>◇</i> Quản lý dự án</a>
        <a class="{{ request()->routeIs('admin.account.*') ? 'active' : '' }}" href="{{ route('admin.account.edit') }}"><i>⚙</i> Tài khoản đăng nhập</a>
    </nav>
    <div class="sidebar-bottom">
        <a href="{{ route('home') }}" target="_blank"><i>↗</i> Xem trang chủ</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button><i>→</i> Đăng xuất</button></form>
        <div class="user-mini"><span>{{ mb_substr(auth()->user()->name, 0, 1) }}</span><div><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->email }}</small></div></div>
    </div>
</aside>
<main class="admin-main">
    <header class="admin-top"><div><small>PORTFOLIO CMS</small><h1>@yield('heading', 'Tổng quan')</h1></div><a class="button primary small" href="{{ route('admin.projects.create') }}">＋ Thêm dự án</a></header>
    @if(session('success'))<div class="alert success">✓ {{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert error"><strong>Vui lòng kiểm tra lại:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @yield('content')
</main>
</body>
</html>
