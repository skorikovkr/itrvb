<?php

namespace Root\Skorikov\Tests;

use PDO;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Root\Skorikov\Infrastructure\SqliteConnector;

final class SqliteConnectorTest extends TestCase
{
    public function testItCreatesInstance(): void
    {
        $conn = SqliteConnector::getConnector();
        $this->assertSame($conn::class, PDO::class);
    }
}