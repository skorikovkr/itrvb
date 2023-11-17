<?php  
namespace Root\Skorikov\Models;

use Root\Skorikov\Infrastructure\UUID;

class Post {
    public function __construct(
        private UUID $uuid,
        private User $authorUserId,
        private string $title,
        private string $text,
    )
    {}
    
    public function __toString() {
        return $this->title . " (id:" . $this->uuid . ")";
    }
}