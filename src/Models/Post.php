<?php  
namespace Root\Skorikov\Models;

class Post {
    public function __construct(
        private int $id,
        private User $authorUserId,
        private string $title,
        private string $text,
    )
    {}
    
    public function __toString() {
        return $this->title . " (id:" . $this->id . ")";
    }
}