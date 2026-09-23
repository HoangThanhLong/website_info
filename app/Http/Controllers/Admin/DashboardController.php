<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'profile' => Profile::query()->first(),
            'projectCount' => Project::query()->count(),
            'visibleProjectCount' => Project::query()->where('is_visible', true)->count(),
            'latestProjects' => Project::query()->latest()->limit(5)->get(),
        ]);
    }
}
