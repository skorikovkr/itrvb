<?php  
namespace Root\Skorikov\Models;

use Root\Skorikov\Infrastructure\UUID;

class Post {
    public function __construct(
        private UUID $uuid,
        private User $authorUser,
        private string $title,
        private string $text,
    )
    {}

    public function getUuid() {
        return $this->uuid;
    }

    public function setUuid($val) {
        $this->uuid = $val;
    }

    public function getAuthorUser() {
        return $this->authorUser;
    }

    public function setAuthorUser($val) {
        $this->authorUser = $val;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($val) {
        $this->title = $val;
    }
    
    public function getText() {
        return $this->text;
    }

    public function setText($val) {
        $this->text = $val;
    }
    
    public function __toString() {
        return $this->title . " (id:" . $this->uuid . ")";
    }
}