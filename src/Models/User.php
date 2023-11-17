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

    public function getUuid() {
        return $this->uuid;
    }

    public function setUuid($val) {
        $this->uuid = $val;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($val) {
        $this->firstName = $val;
    }
    
    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($val) {
        $this->lastName = $val;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($val) {
        $this->username = $val;
    }

    public function __toString() {
        return $this->lastName . " " . $this->firstName;
    }
}