<?php  
namespace Root\Skorikov\Models;

class User {
    public function __construct(
        private int $id,
        private string $firstName,
        private string $lastName
    )
    {}

    public function __toString() {
        return $this->lastName . " " . $this->firstName;
    }
}