<?php

namespace Root\Skorikov\Infrastructure\Tests;

use PDO;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Root\Skorikov\Infrastructure\SqliteConnector;

final class SqliteConnectorTest extends TestCase
{
    private static function cleanUp(): void {
        $reflectionClass = new ReflectionClass(SqliteConnector::class);
        $reflectedProperty = $reflectionClass->getProperty('connection');
        $reflectedProperty->setAccessible(true);
        $reflectedProperty = $reflectedProperty->setValue(null);        
        $reflectedProperty = $reflectionClass->getProperty('instance');
        $reflectedProperty->setAccessible(true);
        $reflectedProperty = $reflectedProperty->setValue(null);
    }

    public function testItCreatesInstance(): void
    {
        $conn = SqliteConnector::getInstance()->getConnector();
        $this->assertSame($conn::class, PDO::class);
        self::cleanUp();
    }

    public function testGetConnectorReturnNullOnNullInstance(): void
    {
        $reflectionClass = new ReflectionClass(SqliteConnector::class);
        $constructor = $reflectionClass->getConstructor();
        $constructor->setAccessible(true);
        $object = $reflectionClass->newInstanceWithoutConstructor();
        $constructor->invoke($object);
        $conn = $object->getConnector();
        $this->assertSame($conn, null);
        self::cleanUp();
    }
}