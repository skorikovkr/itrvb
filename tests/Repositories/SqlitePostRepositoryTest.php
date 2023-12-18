<?php
namespace Root\Skorikov\Tests;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Root\Skorikov\Exceptions\PostNotFoundException;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\Post;
use Root\Skorikov\Repositories\PostRepository\SqlitePostRepository;
use Root\Skorikov\Tests\Helper\DummyLogger;

class SqlitePostRepositoryTest extends TestCase
{
	public function testItThrowsAnExceptionWhenPostNotFound(): void
	{
		$connectionStub = $this->createStub(PDO::class);
		$statementStub = $this->createStub(PDOStatement::class);
		$statementStub->method('fetch')->willReturn(false);
		$connectionStub->method('prepare')->willReturn($statementStub);
		$repository = new SqlitePostRepository($connectionStub, new DummyLogger());
		$this->expectException(PostNotFoundException::class);
        $testUUID = '00fbaf33-a65c-47a9-81a3-feb4a1417363';
		$this->expectExceptionMessage("Post not found (uuid:$testUUID).");
		$repository->get(new UUID($testUUID));
	}

	public function testItFindPost(): void
	{
        $testUUID = 'f1f2fae6-8a72-4ced-84e3-7a66253f25ec';
		$statementStub = $this->createStub(PDOStatement::class);
        $statementStub->method('execute')->willReturn(true);
		$statementStub->method('fetch')->willReturn([
			'author_uuid' => new UUID($testUUID),
			'text' => 'Test-text',
			'title' => 'Test-title',
			'uuid' => new UUID($testUUID)
		]);
		$connectionStub = $this->createStub(PDO::class);
		$connectionStub->method('prepare')->willReturn($statementStub);
		$repository = new SqlitePostRepository($connectionStub, new DummyLogger());
		$entity = $repository->get(new UUID($testUUID));
        $this->assertEquals($entity->getUuid()->__toString(), $testUUID);
        $this->assertEquals($entity->getAuthorUserUuid()->__toString(), $testUUID);
        $this->assertEquals($entity->getTitle(), 'Test-title');
        $this->assertEquals($entity->getText(), 'Test-text');
	}

	public function testItSavesPostToDatabase(): void
	{
        $testUUID = 'f1f2fae6-8a72-4ced-84e3-7a66253f25ec';
		$statementMock = $this->createMock(PDOStatement::class);
		$statementMock->expects($this->once())->method('execute')->with([
			'author_uuid' => new UUID($testUUID),
			'text' => 'Test-text',
			'title' => 'Test-title',
			'uuid' => new UUID($testUUID)
		]);
		$connectionStub = $this->createStub(PDO::class);
		$connectionStub->method('prepare')->willReturn($statementMock);
		$repository = new SqlitePostRepository($connectionStub, new DummyLogger());
		$repository->save(
			new Post(
				new UUID($testUUID),
                new UUID($testUUID),
				'Test-title',
				'Test-text'
			)
		);
	}
}