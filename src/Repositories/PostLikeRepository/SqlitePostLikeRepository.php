<?php
namespace Root\Skorikov\Repositories\PostLikeRepository;

use PDO;
use Psr\Log\LoggerInterface;
use Root\Skorikov\Exceptions\PostNotFoundException;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Exceptions\PostLikeNotFoundException;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\PostLike;
use Root\Skorikov\Repositories\Interfaces\PostLikeRepositoryInterface;

class SqlitePostLikeRepository implements PostLikeRepositoryInterface
{
    public function __construct(
        private PDO $connection,
        private LoggerInterface $logger
    )    
    {
    }

    public function save(PostLike $post): bool {
        $sql = $this->connection->prepare(
            "INSERT INTO PostsLikes (post_uuid,user_uuid,uuid) VALUES (:post_uuid,:user_uuid,:uuid)"
        );
        $existingLike = $this->getByPostAndUserUuid($post->getPostUuid(), $post->getUserUuid());
        if (!is_null($existingLike))
            return false;
        $this->logger->info("Like created: " . $post->getUuid());
        return $sql->execute([
            'post_uuid' => $post->getPostUuid(),
            'user_uuid' => $post->getUserUuid(),
            'uuid' => $post->getUuid()
        ]);
    }

    public function getByPostUuid(UUID $postUuid): array
    {
        $sql = $this->connection->prepare(
            "SELECT * FROM PostsLikes WHERE post_uuid=:postUuid"
        );
        $sql->execute([
            'postUuid' => (string)$postUuid
        ]);
        $result = $sql->fetchAll();
        if (!$result) {
            $this->logger->warning("Post like not found: " . $postUuid);
            throw new PostLikeNotFoundException("PostLike not found with Post.uuid (uuid:$postUuid).");
        }
        $likes = [];
        foreach($result as $row) {
            $likes []= new PostLike(
                new UUID($row['uuid']),
                new UUID($row['user_uuid']),
                new UUID($row['post_uuid'])
            );
        }
        return $likes;
    }

    public function getByPostAndUserUuid(UUID $postUuid, UUID $userUuid) : PostLike | null
    {
        $sql = $this->connection->prepare(
            "SELECT * FROM PostsLikes WHERE post_uuid=:postUuid AND user_uuid=:userUuid"
        );
        $sql->execute([
            'postUuid' => (string)$postUuid,
            'userUuid' => (string)$userUuid,
        ]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }
        return new PostLike(
            new UUID($result['uuid']),
            new UUID($result['user_uuid']),
            new UUID($result['post_uuid'])
        );
    }
}