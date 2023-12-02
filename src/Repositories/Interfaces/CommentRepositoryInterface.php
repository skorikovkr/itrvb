<?php
namespace Root\Skorikov\Repositories\Interfaces;

use Root\Skorikov\Models\Comment;
use Root\Skorikov\Infrastructure\UUID;

interface CommentRepositoryInterface {
    public function save(Comment $comment): bool;

    public function get(UUID $uuid): Comment;
}