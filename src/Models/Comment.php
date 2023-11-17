<?php  
namespace Root\Skorikov\Models;

use Root\Skorikov\Infrastructure\UUID;

class Comment {
    public function __construct(
        private UUID $uuid,
        private User $user,
        private Post $post,
        private string $text,
    )
    {}

    public function getUuid() {
        return $this->uuid;
    }

    public function setUuid($val) {
        $this->uuid = $val;
    }

    public function getUser() {
        return $this->user ;
    }

    public function setUser($val) {
        $this->user = $val;
    }
    
    public function getPost() {
        return $this->post ;
    }

    public function setPost($val) {
        $this->post = $val;
    }
    
    public function getText() {
        return $this->text ;
    }

    public function setText($val) {
        $this->text = $val;
    }

    public function __toString() {
        return $this->user . " wrote: '" . $this->text . "' on post '" . $this->post . "'";
    }
}