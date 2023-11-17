<?php
require_once __DIR__ . '/vendor/autoload.php';

use Faker\Factory;
use Root\Skorikov\Models\Post;
use Root\Skorikov\Models\User;
use Root\Skorikov\Models\Comment;
use Root\Skorikov\Infrastructure\UUID;

$faker = Factory::create();

$user = new User(UUID::random(), $faker->firstName(), $faker->lastName(), $faker->numerify('user-####'));
$user2 = new User(UUID::random(), $faker->firstName(), $faker->lastName(), $faker->numerify('user-####'));
$post = new Post(UUID::random(), $user, "Post Title", "Post text");
$comment = new Comment(UUID::random(), $user2, $post, "Comment text");

echo $comment;