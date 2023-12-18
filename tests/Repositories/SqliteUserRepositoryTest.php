<?php
namespace Root\Skorikov\Tests;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Repositories\UserRepository\SqliteUserRepository;
use Root\Skorikov\Models\User;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Tests\Helper\DummyLogger;

class SqliteUserRepositoryTest extends TestCase
{
	public function testItThrowsAnExceptionWhenUserNotFound(): void
	{
		$connectionStub = $this->createStub(PDO::class);
		$statementStub = $this->createStub(PDOStatement::class);
		$statementStub->method('fetch')->willReturn(false);
		$connectionStub->method('prepare')->willReturn($statementStub);
		$repository = new SqliteUserRepository($connectionStub, new DummyLogger());
		$this->expectException(UserNotFoundException::class);
		$this->expectExceptionMessage('User not found (username:NO_USER_WITH_THAT_USERNAME).');
		$repository->getByUsername('NO_USER_WITH_THAT_USERNAME');
	}

	public function testItSaveUserToDatabase(): void
	{
		$statementMock = $this->createMock(PDOStatement::class);
		$statementMock->expects($this->once())->method('execute')->with([
			'first_name' => 'TestUser-first_name',
			'last_name' => 'TestUser-last_name',
			'username' => 'TestUser-username',
			'uuid' => new UUID('0d5440ef-38d4-420b-bd1c-f882aeb18343')
		]);
		$connectionStub = $this->createStub(PDO::class);
		$connectionStub->method('prepare')->willReturn($statementMock);
		$repository = new SqliteUserRepository($connectionStub, new DummyLogger());
		$repository->save(
			new User(
				new UUID('0d5440ef-38d4-420b-bd1c-f882aeb18343'),
                'TestUser-first_name',
				'TestUser-last_name',
                'TestUser-username'
			)
		);
	}
}