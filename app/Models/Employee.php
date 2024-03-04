<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'work_experience' => 'array',
        'extra_curricular' => 'json',
        'education' => 'array',
        'volunteer_work' => 'json',
        'raw_data' => 'json',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
