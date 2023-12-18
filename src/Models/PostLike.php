<?php  
namespace Root\Skorikov\Models;

use Root\Skorikov\Infrastructure\UUID;

class PostLike {
    public function __construct(
        private UUID $uuid,
        private UUID $userUuid,
        private UUID $postUuid
    )
    {}

    public function getUuid() {
        return $this->uuid;
    }

    public function setUuid($val) {
        $this->uuid = $val;
    }

    public function getUserUuid() {
        return $this->userUuid;
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
}