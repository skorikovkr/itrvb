<?php
namespace Root\Skorikov\Tests;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Root\Skorikov\Exceptions\CommentNotFoundException;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\Comment;
use Root\Skorikov\Repositories\CommentRepository\SqliteCommentRepository;
use Root\Skorikov\Tests\Helper\DummyLogger;

class SqliteCommentRepositoryTest extends TestCase
{
	public function testItThrowsAnExceptionWhenCommentNotFound(): void
	{
		$connectionStub = $this->createStub(PDO::class);
		$statementStub = $this->createStub(PDOStatement::class);
		$statementStub->method('fetch')->willReturn(false);
		$connectionStub->method('prepare')->willReturn($statementStub);
		$repository = new SqliteCommentRepository($connectionStub, new DummyLogger());
		$this->expectException(CommentNotFoundException::class);
        $testUUID = '00fbaf33-a65c-47a9-81a3-feb4a1417363';
		$this->expectExceptionMessage("Comment not found (uuid:$testUUID).");
		$repository->get(new UUID($testUUID));
	}

	public function testItFindComment(): void
	{
        $testUUID = 'f1f2fae6-8a72-4ced-84e3-7a66253f25ec';
		$statementStub = $this->createStub(PDOStatement::class);
        $statementStub->method('execute')->willReturn(true);
		$statementStub->method('fetch')->willReturn([
			'uuid' => new UUID($testUUID),
			'author_uuid' => new UUID($testUUID),
			'post_uuid' => new UUID($testUUID),
			'text' => 'Test-text',
		]);
		$connectionStub = $this->createStub(PDO::class);
		$connectionStub->method('prepare')->willReturn($statementStub);
		$repository = new SqliteCommentRepository($connectionStub, new DummyLogger());
		$entity = $repository->get(new UUID($testUUID));
        $this->assertEquals($entity->getUuid()->__toString(), $testUUID);
        $this->assertEquals($entity->getUserUuid()->__toString(), $testUUID);
        $this->assertEquals($entity->getPostUuid()->__toString(), $testUUID);
        $this->assertEquals($entity->getText(), 'Test-text');
	}

	public function testItSavesCommentToDatabase(): void
	{
        $testUUID = 'f1f2fae6-8a72-4ced-84e3-7a66253f25ec';
		$statementMock = $this->createMock(PDOStatement::class);
		$statementMock->expects($this->once())->method('execute')->with([
			'post_uuid' => new UUID($testUUID),
			'text' => 'Test-text',
			'author_uuid' => new UUID($testUUID),
			'uuid' => new UUID($testUUID)
		]);
		$connectionStub = $this->createStub(PDO::class);
		$connectionStub->method('prepare')->willReturn($statementMock);
		$repository = new SqliteCommentRepository($connectionStub, new DummyLogger());
		$repository->save(
			new Comment(
				new UUID($testUUID),
                new UUID($testUUID),
                new UUID($testUUID),
				'Test-text'
			)
		);
	}
}