<?php  
namespace Root\Skorikov\Models;

use Root\Skorikov\Infrastructure\UUID;

class Comment {
    public function __construct(
        private UUID $uuid,
        private UUID $userUuid,
        private UUID $postUuid,
        private string $text,
    )
    {}

    public function getUuid() {
        return $this->uuid;
    }

    public function setUuid($val) {
        $this->uuid = $val;
    }

    public function getUserUuid() {
        return $this->userUuid ;
    }

    public function setUserUuid($val) {
        $this->userUuid = $val;
    }
    
    public function getPostUuid() {
        return $this->postUuid;
    }

    public function setPostUuid($val) {
        $this->postUuid = $val;
    }
    
    public function getText() {
        return $this->text ;
    }

    public function setText($val) {
        $this->text = $val;
    }

    public function __toString() {
        return $this->userUuid . " wrote: '" . $this->text . "' on post '" . $this->postUuid . "'";
    }
}