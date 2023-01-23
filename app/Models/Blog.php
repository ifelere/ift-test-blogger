<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Blog model to store blogs
 * 
 */
class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime'
    ];
}
