<?php
namespace Root\Skorikov\Repositories\Interfaces;

use Root\Skorikov\Models\CommentLike;
use Root\Skorikov\Infrastructure\UUID;

interface CommentLikeRepositoryInterface {
    public function save(CommentLike $like): bool;

    public function getByCommentAndUserUuid(UUID $commentUuid, UUID $userUuid): CommentLike | null;

    public function getByCommentUuid(UUID $commentUuid): array;
}