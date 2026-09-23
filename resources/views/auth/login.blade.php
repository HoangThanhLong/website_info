<!DOCTYPE html>
<html lang="vi">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Đăng nhập quản trị</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="{{ asset('css/app.css') }}"></head>
<body class="login-body">
<div class="login-art"><a class="brand" href="{{ route('home') }}"><span>HL</span> Portfolio</a><div><p>PORTFOLIO CMS</p><h1>Không gian<br>của những<br><em>ý tưởng.</em></h1><span>Quản lý câu chuyện, dự án và dấu ấn cá nhân của bạn tại một nơi.</span></div><small>© {{ date('Y') }} Portfolio</small></div>
<main class="login-panel"><div class="login-box"><a class="back-link" href="{{ route('home') }}">← Về trang chủ</a><p class="eyebrow">KHU VỰC QUẢN TRỊ</p><h2>Chào mừng trở lại</h2><p>Đăng nhập để tiếp tục quản lý portfolio.</p>
    @if($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('login.store') }}" class="form-stack">@csrf
        <label>Email<input type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus></label>
        <label>Mật khẩu<input type="password" name="password" placeholder="••••••••" required></label>
        <label class="check"><input type="checkbox" name="remember" value="1"> Ghi nhớ đăng nhập</label>
        <button class="button primary full" type="submit">Đăng nhập <span>→</span></button>
    </form>
</div></main>
</body></html>
