<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = ['year', 'title', 'organization', 'description', 'proof_url', 'proofs', 'order'];

    protected $casts = [
        'proofs' => 'array'
    ];
}
