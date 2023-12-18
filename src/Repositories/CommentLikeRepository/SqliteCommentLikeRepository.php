<?php
namespace Root\Skorikov\Repositories\CommentLikeRepository;

use PDO;
use Root\Skorikov\Exceptions\PostNotFoundException;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Exceptions\CommentLikeNotFoundException;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\CommentLike;
use Root\Skorikov\Repositories\Interfaces\CommentLikeRepositoryInterface;

class SqliteCommentLikeRepository implements CommentLikeRepositoryInterface
{
    public function __construct(
        private PDO $connection
    )    
    {
    }

    public function save(CommentLike $post): bool {
        $sql = $this->connection->prepare(
            "INSERT INTO CommentsLikes (comment_uuid,user_uuid,uuid) VALUES (:comment_uuid,:user_uuid,:uuid)"
        );
        $existingLike = $this->getByCommentAndUserUuid($post->getCommentUuid(), $post->getUserUuid());
        if (!is_null($existingLike))
            return false;
        return $sql->execute([
            'comment_uuid' => $post->getCommentUuid(),
            'user_uuid' => $post->getUserUuid(),
            'uuid' => $post->getUuid()
        ]);
    }

    public function getByCommentUuid(UUID $commentUuid): array
    {
        $sql = $this->connection->prepare(
            "SELECT * FROM CommentsLikes WHERE comment_uuid=:commentUuid"
        );
        $sql->execute([
            'commentUuid' => (string)$commentUuid
        ]);
        $result = $sql->fetchAll();
        if (!$result) {
            throw new CommentLikeNotFoundException("CommentLike not found with Comment.uuid (uuid:$commentUuid).");
        }
        $likes = [];
        foreach($result as $row) {
            $likes []= new CommentLike(
                new UUID($row['uuid']),
                new UUID($row['user_uuid']),
                new UUID($row['comment_uuid'])
            );
        }
        return $likes;
    }

    public function getByCommentAndUserUuid(UUID $commentUuid, UUID $userUuid) : CommentLike | null
    {
        $sql = $this->connection->prepare(
            "SELECT * FROM CommentsLikes WHERE comment_uuid=:commentUuid AND user_uuid=:userUuid"
        );
        $sql->execute([
            'commentUuid' => (string)$commentUuid,
            'userUuid' => (string)$userUuid,
        ]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }
        return new CommentLike(
            new UUID($result['uuid']),
            new UUID($result['user_uuid']),
            new UUID($result['comment_uuid'])
        );
    }
}