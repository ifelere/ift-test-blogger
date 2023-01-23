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

    public function publisher() {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    public function scopePublishedBy($builder, $id) {
        return $builder->where('publisher_id', $id);
    }
}
