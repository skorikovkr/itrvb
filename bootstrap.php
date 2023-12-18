<?php

use Root\Skorikov\Infrastructure\Container\DIContainer;
use Root\Skorikov\Infrastructure\Http\Auth\IdentificationInterface;
use Root\Skorikov\Infrastructure\Http\Auth\JsonBodyUuidIdentification;
use Root\Skorikov\Infrastructure\SqliteConnector;
use Root\Skorikov\Repositories\CommentRepository\SqliteCommentRepository;
use Root\Skorikov\Repositories\Interfaces\CommentLikeRepositoryInterface;
use Root\Skorikov\Repositories\Interfaces\CommentRepositoryInterface;
use Root\Skorikov\Repositories\Interfaces\PostLikeRepositoryInterface;
use Root\Skorikov\Repositories\Interfaces\PostRepositoryInterface;
use Root\Skorikov\Repositories\UserRepository\SqliteUserRepository;
use Root\Skorikov\Repositories\Interfaces\UserRepositoryInterface;
use Root\Skorikov\Repositories\CommentLikeRepository\SqliteCommentLikeRepository;
use Root\Skorikov\Repositories\PostLikeRepository\SqlitePostLikeRepository;
use Root\Skorikov\Repositories\PostRepository\SqlitePostRepository;

require_once __DIR__ . '/vendor/autoload.php';

$container = new DIContainer;

$container->bind(PDO::class, SqliteConnector::getConnector());
$container->bind(UserRepositoryInterface::class, SqliteUserRepository::class);
$container->bind(PostRepositoryInterface::class, SqlitePostRepository::class);
$container->bind(CommentRepositoryInterface::class, SqliteCommentRepository::class);
$container->bind(PostLikeRepositoryInterface::class, SqlitePostLikeRepository::class);
$container->bind(CommentLikeRepositoryInterface::class, SqliteCommentLikeRepository::class);
$container->bind(IdentificationInterface::class, JsonBodyUuidIdentification::class);

return $container;
