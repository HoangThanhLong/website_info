<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', ['profile' => Profile::query()->firstOrCreate([], [
            'full_name' => 'Tên của bạn',
        ])]);
    }

    public function update(Request $request): RedirectResponse
    {
        $profile = Profile::query()->firstOrFail();
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'headline' => ['nullable', 'string', 'max:180'],
            'gender' => ['nullable', Rule::in(['Nam', 'Nữ', 'Khác'])],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'bio' => ['nullable', 'string', 'max:3000'],
            'interests' => ['nullable', 'string', 'max:1000'],
            'email' => ['nullable', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:150'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
        ]);

        $data['interests'] = collect(explode(',', $data['interests'] ?? ''))
            ->map(fn ($item) => trim($item))->filter()->values()->all();

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) Storage::disk('public')->delete($profile->avatar);
            $data['avatar'] = $request->file('avatar')->store('profiles', 'public');
        }

        $profile->update($data);

        return back()->with('success', 'Đã cập nhật thông tin cá nhân.');
    }
}
