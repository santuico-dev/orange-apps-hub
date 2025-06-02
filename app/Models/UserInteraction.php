<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInteraction extends Model
{
    use HasFactory;

    protected $table = 'friend_request';

    protected $fillable = [
        'friend_request_from',
        'friend_request_to',
        'friend_request_status',
        'friend_request_created_at',
    ];
}
