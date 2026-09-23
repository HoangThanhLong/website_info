<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        Profile::query()->create(['full_name' => 'Hoàng Long']);
        $response = $this->get('/');
        $response->assertOk()->assertSee('Hoàng Long');
    }

    public function test_guest_cannot_access_admin_pages(): void
    {
        $this->get('/admin')->assertRedirect('/dang-nhap');
        $this->get('/admin/projects')->assertRedirect('/dang-nhap');
    }

    public function test_user_can_login_and_manage_a_project(): void
    {
        $user = User::factory()->create(['password' => 'secret-password']);

        $this->post('/dang-nhap', ['email' => $user->email, 'password' => 'secret-password'])
            ->assertRedirect('/admin');

        $this->actingAs($user)->post('/admin/projects', [
            'name' => 'Website bán hàng',
            'description' => 'Một dự án kiểm thử đầy đủ.',
            'url' => 'https://example.com',
            'completed_at' => '2026-01-20',
            'sort_order' => 1,
            'is_visible' => 1,
        ])->assertRedirect('/admin/projects');

        $this->assertDatabaseHas(Project::class, ['name' => 'Website bán hàng', 'is_visible' => true]);
    }

    public function test_user_can_update_login_email_and_password(): void
    {
        $user = User::factory()->create(['password' => 'old-password']);

        $this->actingAs($user)->put('/admin/tai-khoan', [
            'name' => 'New Administrator',
            'email' => 'new-admin@example.com',
            'current_password' => 'old-password',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertRedirect();

        $user->refresh();
        $this->assertSame('new-admin@example.com', $user->email);
        $this->assertTrue(Hash::check('new-password-123', $user->password));
    }
}
