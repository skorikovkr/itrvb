<?php

namespace Root\Skorikov\Infrastructure\Tests;

use PDOException;
use PHPUnit\Framework\TestCase;
use Root\Skorikov\Exceptions\InvalidArgumentException;
use Root\Skorikov\Infrastructure\SqliteTestConnector;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\Comment;
use Root\Skorikov\Models\Post;
use Root\Skorikov\Repositories\CommentRepository\SqliteCommentRepository;

final class SqliteCommentRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        //self::cleanUp();
    }

    private static function cleanUp(): void {
        $sql = file_get_contents('init_db_test.sql');
        $connection = SqliteTestConnector::getConnector();
        $sql = $connection->prepare($sql);
        $sql->execute();
    }

    public function testSuccessSave(): void
    {
        $connection = SqliteTestConnector::getConnector();
        $rep = new SqliteCommentRepository($connection);
        $rep->save(new Comment(
            new UUID('e97863b1-c1e1-4193-8739-d0ea045e8dba'),
            new UUID('f09a2aac-ba50-4eb7-9036-6e27466ab17a'),
            new UUID('c336bc52-e711-44bd-b0f5-ada649328281'),
            'test-text'
        ));
    }

    public function testNotSuccessSaveNotUniqueFK(): void
    {
        $this->expectException(PDOException::class);
        $connection = SqliteTestConnector::getConnector();
        $rep = new SqliteCommentRepository($connection);
        $rep->save(new Comment(
            new UUID('f1f2fae6-8a72-4ced-84e3-7a66253f25ec'),
            new UUID('f09a2aac-ba50-4eb7-9036-6e27466ab17a'),
            new UUID('c336bc52-e711-44bd-b0f5-ada649328281'),
            'test-text'
        ));
    }
}