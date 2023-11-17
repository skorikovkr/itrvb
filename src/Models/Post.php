<?php  
namespace Root\Skorikov\Models;

use Root\Skorikov\Infrastructure\UUID;

class Post {
    public function __construct(
        private UUID $uuid,
        private Uuid $authorUserUuid,
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

    public function getAuthorUserUuid() {
        return $this->authorUserUuid;
    }

    public function setAuthorUserUuid($val) {
        $this->authorUserUuid = $val;
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