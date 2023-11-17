<?php
namespace Root\Skorikov\Repositories\Interfaces;

use Root\Skorikov\Models\User;
use Root\Skorikov\Infrastructure\UUID;

interface UserRepositoryInterface {
    public function save(User $user): void;

    public function get(UUID $uuid): User;
}