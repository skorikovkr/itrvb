<?php
require_once __DIR__ . '/vendor/autoload.php';

use Faker\Factory;
use Root\Skorikov\Models\Post;
use Root\Skorikov\Models\User;
use Root\Skorikov\Models\Comment;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Repositories\UserRepository\SqliteUserRepository;

$faker = Factory::create();

$rep = new SqliteUserRepository();
$user = $rep->get(new UUID('013782d3-5b7f-4518-b352-4a2aa6fbd86b'));

echo $user;