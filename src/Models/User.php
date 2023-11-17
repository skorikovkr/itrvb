<?php  
namespace Root\Skorikov\Models;

use Root\Skorikov\Infrastructure\UUID;

class User {
    public function __construct(
        private UUID $uuid,
        private string $firstName,
        private string $lastName,
        private string $username
    )
    {}

    public function __toString() {
        return $this->lastName . " " . $this->firstName;
    }
}