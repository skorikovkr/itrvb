<?php  
namespace Root\Skorikov\Models;

class Comment {
    public function __construct(
        private int $id,
        private User $user,
        private Post $post,
        private string $text,
    )
    {}

    public function __toString() {
        return $this->user . " wrote: '" . $this->text . "' on post '" . $this->post . "'";
    }
}