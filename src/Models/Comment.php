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

    public function __toString() {
        return $this->user . " wrote: '" . $this->text . "' on post '" . $this->post . "'";
    }
}