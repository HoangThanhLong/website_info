<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'slug', 'image', 'url', 'description', 'completed_at', 'sort_order', 'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'date',
            'is_visible' => 'boolean',
        ];
    }
}
