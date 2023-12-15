<?php
namespace Root\Skorikov\Repositories\Interfaces;

use Root\Skorikov\Models\Post;
use Root\Skorikov\Infrastructure\UUID;

interface PostRepositoryInterface {
    public function save(Post $post): void;

    public function get(UUID $uuid): Post;

    public function delete(UUID $uuid): void;
}