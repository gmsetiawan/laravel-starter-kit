<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'status',
        'author_id',
        'meta_description',
        'meta_keywords',
    ];

    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);
        $count = 1;

        while ($this->where('slug', $slug)->exists()) {
            $slug = Str::slug($value) . '-' . $count++;
        }

        $this->attributes['slug'] = $slug;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
