<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use App\Http\Controllers\PostController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'published_at',
        'image_url',
        'category_id',
        'status'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => PostStatusEnum::class
    ];

    public function category()
    {
        return $this->BelongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
