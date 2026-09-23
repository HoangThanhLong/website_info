@extends('layouts.admin')
@section('title', 'Tài khoản đăng nhập')
@section('heading', 'Tài khoản đăng nhập')

@section('content')
<form method="POST" action="{{ route('admin.account.update') }}">
    @csrf
    @method('PUT')

    <section class="admin-card">
        <div class="card-heading">
            <div><span>TÀI KHOẢN</span><h2>Thông tin đăng nhập</h2></div>
        </div>

        <div class="account-note">
            <span>i</span>
            <p>Email dưới đây dùng để đăng nhập khu vực quản trị. Đây không phải email liên hệ hiển thị ngoài trang chủ.</p>
        </div>

        <div class="form-grid">
            <label>Họ tên quản trị viên *
                <input name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
            </label>
            <label>Email đăng nhập *
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
            </label>
        </div>
    </section>

    <section class="admin-card">
        <div class="card-heading">
            <div><span>BẢO MẬT</span><h2>Đổi mật khẩu</h2></div>
        </div>

        <p class="form-hint">Để trống các trường bên dưới nếu bạn không muốn đổi mật khẩu.</p>
        <div class="form-grid">
            <label class="span-2">Mật khẩu hiện tại
                <input type="password" name="current_password" autocomplete="current-password">
            </label>
            <label>Mật khẩu mới
                <input type="password" name="password" autocomplete="new-password">
                <small>Tối thiểu 8 ký tự.</small>
            </label>
            <label>Xác nhận mật khẩu mới
                <input type="password" name="password_confirmation" autocomplete="new-password">
            </label>
        </div>
    </section>

    <div class="form-actions">
        <button class="button primary" type="submit">Lưu thay đổi</button>
    </div>
</form>
@endsection
