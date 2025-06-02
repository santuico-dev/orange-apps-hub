<?php

namespace App\Repositories;

use App\Models\PostInteraction;
use App\Repositories\Interface\PostInteractionInterface;
class PostInteractionRepository implements PostInteractionInterface {

    public function createPostComment($commentData): ?PostInteraction
    {
        return PostInteraction::create($commentData);
    }
}
