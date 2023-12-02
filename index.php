<?php
require_once __DIR__ . '/vendor/autoload.php';

use Faker\Factory;
use Root\Skorikov\Infrastructure\SqliteConnector;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\User;
use Root\Skorikov\Repositories\CommentRepository\SqliteCommentRepository;
use Root\Skorikov\Repositories\PostRepository\SqlitePostRepository;
use Root\Skorikov\Repositories\UserRepository\SqliteUserRepository;

$faker = Factory::create();

$connection = SqliteConnector::getConnector();

$user_rep = new SqliteUserRepository($connection);
$user_res = $user_rep->get(new UUID('013782d3-5b7f-4518-b352-4a2aa6fbd86b'));
echo $user_res . "\n";

$post_rep = new SqlitePostRepository($connection);
$post_res = $post_rep->get(new UUID('c336bc52-e711-44bd-b0f5-ada649328281'));
echo $post_res . "\n";

$comment_rep = new SqliteCommentRepository($connection);
$comment_res = $comment_rep->get(new UUID('f1f2fae6-8a72-4ced-84e3-7a66253f25ec'));
echo $comment_res . "\n";