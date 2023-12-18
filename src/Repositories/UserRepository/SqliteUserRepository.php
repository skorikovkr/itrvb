<?php
namespace Root\Skorikov\Repositories\UserRepository;

use PDO;
use Psr\Log\LoggerInterface;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Infrastructure\SqliteConnector;
use Root\Skorikov\Models\User;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Repositories\Interfaces\UserRepositoryInterface;

class SqliteUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private PDO $connection,
        private LoggerInterface $logger
    )    
    {
    }

    public function save(User $user): bool {
        $sql = $this->connection->prepare(
            "INSERT INTO users (first_name,last_name,username,uuid) VALUES (:first_name,:last_name,:username,:uuid)"
        );
        $this->logger->info("User created: " . $user->getUuid());
        return $sql->execute([
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
            $this->logger->warning("User not found: " . $uuid);
            throw new UserNotFoundException("User not found (uuid:$uuid).");
        }
        return new User(
            new UUID($result['uuid']),
            $result['first_name'],
            $result['last_name'],
            $result['username']
        );
    }

	public function getByUsername(string $username): User
	{
		$statement = $this->connection->prepare(
			'SELECT * FROM users WHERE username = :username'
		);
		$statement->execute([
			':username' => $username,
		]);
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		if ($result === false) {
            $this->logger->warning("User not found: " . $username);
			throw new UserNotFoundException(
				"User not found (username:$username)."
			);
		}
		return new User(
			new UUID($result['uuid']),
            $result['first_name'],
            $result['last_name'],
			$result['username']
		);
	}
}