<?php
namespace Root\Skorikov\Repositories\PostRepository;

use PDO;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Infrastructure\SqliteConnector;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\Post;
use Root\Skorikov\Repositories\Interfaces\PostRepositoryInterface;

class SqlitePostRepository implements PostRepositoryInterface
{
    private PDO $connection;

    public function __construct()    
    {
        $this->connection = SqliteConnector::getInstance()->getConnector();
    }

    public function save(Post $post): void {
        $sql = $this->connection->prepare(
            "INSERT INTO posts (title,text,author_uuid,uuid) VALUES (:title,:text,:author_uuid,:uuid)"
        );
        $sql->execute([
            'title' => $post->getTitle(),
            'text' => $post->getText(),
            'author_uuid' => $post->getAuthorUserUuid(),
            'uuid' => $post->getUuid()
        ]);
    }

    public function get(UUID $uuid): Post {
        $sql = $this->connection->prepare(
            "SELECT * FROM posts WHERE uuid=:uuid"
        );
        $sql->execute([
            'uuid' => (string)$uuid
        ]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new UserNotFoundException("Post not found (uuid:$uuid).");
        }
        return new Post(
            new UUID($result['uuid']),
            new UUID($result['author_uuid']),
            $result['title'],
            $result['text']
        );
    }
}