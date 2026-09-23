<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::query()->doesntExist()) {
            User::query()->create([
                'name' => env('ADMIN_NAME', 'Quản trị viên'),
                'email' => env('ADMIN_EMAIL', 'admin@example.com'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'ChangeMe123!')),
            ]);
        }

        Profile::query()->firstOrCreate([], [
            'full_name' => 'Hoàng Long',
            'headline' => 'Laravel Developer · Biến ý tưởng thành sản phẩm số',
            'gender' => 'Nam',
            'birth_date' => '2000-01-01',
            'bio' => 'Xin chào! Tôi là một lập trình viên yêu thích việc xây dựng những sản phẩm web chỉn chu, nhanh và hữu ích. Tôi luôn tò mò với công nghệ mới và coi mỗi dự án là một cơ hội để tạo ra điều có giá trị.',
            'interests' => ['Lập trình', 'Công nghệ', 'Du lịch', 'Nhiếp ảnh'],
            'email' => 'hello@example.com',
            'location' => 'Việt Nam',
            'github_url' => 'https://github.com/',
        ]);

        if (Project::query()->doesntExist()) Project::query()->create([
            'name' => 'Portfolio cá nhân',
            'slug' => 'portfolio-ca-nhan',
            'url' => 'https://example.com',
            'description' => 'Website giới thiệu bản thân và quản lý các dự án nổi bật, được xây dựng với Laravel và Docker.',
            'completed_at' => now()->startOfMonth(),
            'sort_order' => 1,
            'is_visible' => true,
        ]);
    }
}
