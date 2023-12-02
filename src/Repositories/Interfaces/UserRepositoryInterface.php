<?php
namespace Root\Skorikov\Repositories\Interfaces;

use Root\Skorikov\Models\User;
use Root\Skorikov\Infrastructure\UUID;

interface UserRepositoryInterface {
    public function save(User $user): bool;

    public function get(UUID $uuid): User;

	public function getByUsername(string $username): User;
}