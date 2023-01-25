<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

use Illuminate\Support\Str;

/**
 * Blog model to store blogs
 * 
 */
class Blog extends Model implements Feedable
{
    use HasFactory;
    

    protected $fillable = ['title', 'description', 'published_at', 'publisher_id', 'slug'];

    protected $casts = [
        'published_at' => 'datetime',
        'earliest_publish_date' => 'datetime',
        'latest_publish_date' => 'datetime'
    ];

    public function publisher() {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    public function scopePublishedBy($builder, $id) {
        return $builder->where('publisher_id', $id);
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => Str::limit($this->description, 255),
            'updated' => $this->updated_at,
            'link' => route('blogs.show', ['blog' => $this->slug]),
            'authorName' => $this->publisher->is_system ? '(imported)' : $this->publisher->name,
        ]);
    }

    public static function getAllBlogs()
    {
        return Blog::with(['publisher'])->get();
    }
}
