# Portfolio cá nhân Laravel

Website portfolio gồm trang giới thiệu công khai và khu vực quản trị bảo vệ bằng đăng nhập. Toàn bộ ứng dụng chạy trong Docker với Laravel 12, PHP 8.4, Nginx và MySQL 8.4.

## Chạy nhanh

1. Sao chép cấu hình và đổi mật khẩu trước khi đưa lên VPS:

   ```bash
   cp .env.example .env
   ```

2. Chỉnh ít nhất các biến `APP_URL`, `DB_PASSWORD`, `MYSQL_ROOT_PASSWORD`, `ADMIN_EMAIL`, `ADMIN_PASSWORD` trong `.env`.

3. Khởi động:

   ```bash
   docker compose up -d --build
   ```

4. Mở `http://localhost:8080`. Đăng nhập tại `/dang-nhap` bằng tài khoản đã cấu hình trong `.env`.

Sau khi đăng nhập, vào **Tài khoản đăng nhập** để thay đổi tên quản trị viên, email hoặc mật khẩu. Email liên hệ hiển thị trên trang chủ được chỉnh riêng tại **Thông tin cá nhân**.

Ảnh dự án hỗ trợ JPG, PNG và WebP với dung lượng tối đa 50MB.
Ảnh chụp toàn bộ website dạng dọc sẽ cuộn từ trên xuống dưới khi rê chuột vào thẻ dự án ở trang chủ.

Migration, dữ liệu khởi tạo và application key được xử lý tự động khi container chạy. Dữ liệu MySQL và ảnh upload nằm trong Docker volumes nên vẫn được giữ khi cập nhật container.

## Lệnh vận hành

```bash
# Xem log
docker compose logs -f app web

# Dừng dịch vụ (không xóa dữ liệu)
docker compose down

# Sao lưu cơ sở dữ liệu
docker compose exec -T db sh -c 'mysqldump -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"' > backup.sql
```

Để chạy bộ kiểm thử trong môi trường phát triển có PHP 8.4 và Composer: `php artisan test`.

Không dùng `docker compose down -v` trên máy chủ thật vì tùy chọn `-v` sẽ xóa database và ảnh đã tải lên.
