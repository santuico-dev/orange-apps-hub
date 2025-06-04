<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';

    protected $fillable = [
        'user_id',
        'post_content',
        'restriction_type',
        'post_like_count',
        'post_comment_count',
        'post_created_at'
    ];

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
