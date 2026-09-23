<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'full_name', 'headline', 'gender', 'birth_date', 'avatar', 'bio',
        'interests', 'email', 'phone', 'location', 'github_url', 'facebook_url',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'interests' => 'array',
        ];
    }
}
