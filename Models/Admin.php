<?php

namespace itrvb\onlineshop;

class Admin extends User {

    private $adding_allowed;
    private $editing_allowed;
    private $deleting_allowed;

    public function get_adding_allowed() {
        return $this->$adding_allowed;
    }

    public function set_adding_allowed($adding_allowed) {
        $this->$adding_allowed = $adding_allowed;
    }

    public function get_editing_allowed() {
        return $this->$editing_allowed;
    }

    public function set_editing_allowed($editing_allowed) {
        $this->$editing_allowed = $editing_allowed;
    }
}