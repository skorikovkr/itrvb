<?php
namespace Root\Skorikov\Repositories\CommentRepository;

use PDO;
use Root\Skorikov\Exceptions\CommentNotFoundException;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\Comment;
use Root\Skorikov\Repositories\Interfaces\CommentRepositoryInterface;

class SqliteCommentRepository implements CommentRepositoryInterface
{
    public function __construct(
        private PDO $connection
    )    
    {
    }

    public function save(Comment $post): bool {
        $sql = $this->connection->prepare(
            "INSERT INTO comments (post_uuid,text,author_uuid,uuid) VALUES (:post_uuid,:text,:author_uuid,:uuid)"
        );
        return $sql->execute([
            'post_uuid' => $post->getPostUuid(),
            'text' => $post->getText(),
            'author_uuid' => $post->getUserUuid(),
            'uuid' => $post->getUuid()
        ]);
    }

    public function get(UUID $uuid): Comment {
        $sql = $this->connection->prepare(
            "SELECT * FROM comments WHERE uuid=:uuid"
        );
        $sql->execute([
            'uuid' => (string)$uuid
        ]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new CommentNotFoundException("Comment not found (uuid:$uuid).");
        }
        return new Comment(
            new UUID($result['uuid']),
            new UUID($result['author_uuid']),
            new UUID($result['post_uuid']),
            $result['text']
        );
    }
}