<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostInteraction extends Model
{
    use HasFactory;

    protected $table = 'user_comments';

    protected $fillable = [
      'post_id',
      'user_id',
      'comment_content',
      'comment_created_at'
    ];
}
