<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'objective_title',
        'image_path',
        'career_objective',
        'details'
    ];

    protected $casts = [
        'details' => 'array'
    ];
}
