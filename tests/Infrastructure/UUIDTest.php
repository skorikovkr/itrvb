<?php

namespace Root\Skorikov\Infrastructure\Tests;

use PHPUnit\Framework\TestCase;
use Root\Skorikov\Exceptions\InvalidArgumentException;
use Root\Skorikov\Infrastructure\UUID;

final class UUIDTest extends TestCase
{
    public function testCtor(): void
    {
        $uuid = new UUID('f09a2aac-ba50-4eb7-9036-6e27466ab17a');
        $this->assertSame(
            $uuid->__toString(), 
            'f09a2aac-ba50-4eb7-9036-6e27466ab17a'
        );
    }

    public function testThrowExceptionOnInvalidUuid(): void
    { 
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid UUID: invalid-uuid");
        new UUID('invalid-uuid');
    }

    public function testRandomUuid(): void
    {
        $uuid = UUID::random();
        $this->assertNotEmpty($uuid);
    }
}