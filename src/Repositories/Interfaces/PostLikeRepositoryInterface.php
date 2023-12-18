<?php
namespace Root\Skorikov\Repositories\Interfaces;

use Root\Skorikov\Models\PostLike;
use Root\Skorikov\Infrastructure\UUID;

interface PostLikeRepositoryInterface {
    public function save(PostLike $like): bool;

    public function getByPostAndUserUuid(UUID $postUuid, UUID $userUuid): PostLike | null;

    public function getByPostUuid(UUID $postUuid): array;
}