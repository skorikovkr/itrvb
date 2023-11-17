<?php
namespace Root\Skorikov\Repositories\UserRepository;

use PDO;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Infrastructure\SqliteConnector;
use Root\Skorikov\Models\User;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Repositories\Interfaces\UserRepositoryInterface;

class SqliteUserRepository implements UserRepositoryInterface
{
    private PDO $connection;

    public function __construct()    
    {
        $this->connection = SqliteConnector::getInstance()->getConnector();
    }

    public function save(User $user): void {
        $sql = $this->connection->prepare(
            "INSERT INTO users (first_name,last_name,username,uuid) VALUES (:first_name,:last_name,:username,:uuid)"
        );
        $sql->execute([
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'username' => $user->getUsername(),
            'uuid' => $user->getUuid()
        ]);
    }

    public function get(UUID $uuid): User {
        $sql = $this->connection->prepare(
            "SELECT * FROM users WHERE uuid=:uuid"
        );
        $sql->execute([
            'uuid' => (string)$uuid
        ]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new UserNotFoundException("User not found (uuid:$uuid).");
        }
        return new User(
            new UUID($result['uuid']),
            $result['first_name'],
            $result['last_name'],
            $result['username']
        );
    }
}