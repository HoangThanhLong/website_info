<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', ['projects' => Project::query()->orderBy('sort_order')->latest()->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_visible'] = $request->boolean('is_visible');
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('projects', 'public');
        Project::query()->create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Đã thêm dự án mới.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $project->id);
        $data['is_visible'] = $request->boolean('is_visible');
        if ($request->hasFile('image')) {
            if ($project->image) Storage::disk('public')->delete($project->image);
            $data['image'] = $request->file('image')->store('projects', 'public');
        }
        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Đã cập nhật dự án.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->image) Storage::disk('public')->delete($project->image);
        $project->delete();

        return back()->with('success', 'Đã xóa dự án.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'url' => ['nullable', 'url', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'completed_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ], [
            'image.image' => 'Tệp tải lên phải là một hình ảnh hợp lệ.',
            'image.mimes' => 'Ảnh dự án chỉ hỗ trợ định dạng JPG, PNG hoặc WebP.',
            'image.max' => 'Ảnh dự án không được lớn hơn 50MB.',
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'du-an';
        $slug = $base;
        $number = 2;
        while (Project::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$number++;
        }
        return $slug;
    }
}
