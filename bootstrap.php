<?php

use Root\Skorikov\Infrastructure\Container\DIContainer;
use Root\Skorikov\Repositories\UserRepository\SqliteUserRepository;
use Root\Skorikov\Repositories\Interfaces\UserRepositoryInterface;

require_once __DIR__ . '/vendor/autoload.php';

$container = new DIContainer;

$container->bind(PDO::class, new PDO('sqlite:' . __DIR__ . '/blog.sqlite'));
$container->bind(UserRepositoryInterface::class, SqliteUserRepository::class);

return $container;
