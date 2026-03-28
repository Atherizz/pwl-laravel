<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'slug', 'category_id', 'color', 'image', 'body', 'tags', 'published', 'published_at'])]
class Post extends Model
{
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published' => 'boolean',
            'published_at' => 'date',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
