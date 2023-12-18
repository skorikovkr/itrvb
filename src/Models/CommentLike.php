<?php  
namespace Root\Skorikov\Models;

use Root\Skorikov\Infrastructure\UUID;

class CommentLike {
    public function __construct(
        private UUID $uuid,
        private UUID $userUuid,
        private UUID $commentUuid
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

    public function getCommentUuid() {
        return $this->commentUuid;
    }

    public function setCommentUuid($val) {
        $this->commentUuid = $val;
    }
}