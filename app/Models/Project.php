<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $casts = [
        'tech_stack' => 'json',
        'raw_data' => 'json',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
