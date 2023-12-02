<?php

use Root\Skorikov\Infrastructure\Arguments;
use Root\Skorikov\Commands\CreateUserCommand;
use Root\Skorikov\Exceptions\CommandException;

$container = require __DIR__ . '/bootstrap.php';

$command = $container->get(CreateUserCommand::class);

try {
	$command->handle(Arguments::fromArgv($argv));
} catch (CommandException $error) {
	echo "{$error->getMessage()}\n";
}