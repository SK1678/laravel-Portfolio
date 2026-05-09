<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'buttons' => 'array',
        'show_cv_button' => 'boolean',
        'btn_outline' => 'boolean',
        'cv_outline' => 'boolean',
    ];
}
