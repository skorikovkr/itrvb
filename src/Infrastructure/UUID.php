<?php
namespace Root\Skorikov\Infrastructure;

use Root\Skorikov\Exceptions\InvalidArgumentException;

class UUID {
    public function __construct(
        private readonly string $uuid
    )
    {
        if (!\uuid_is_valid($uuid)) {
            throw new InvalidArgumentException("Invalid UUID: $uuid");
        }
    }

    public function __toString(): string {
        return $this->uuid;
    }

    public static function random(): self {
        return new UUID(\uuid_create(UUID_TYPE_RANDOM));
    }
}
