<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'profile' => Profile::query()->first(),
            'projects' => Project::query()->where('is_visible', true)
                ->orderBy('sort_order')->orderByDesc('completed_at')->get(),
        ]);
    }
}
