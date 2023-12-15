<?php

use Root\Skorikov\Actions\Posts\CreateComment;
use Root\Skorikov\Exceptions\HttpException;
use Root\Skorikov\Actions\Users\CreateUser;
use Root\Skorikov\Actions\Posts\CreatePost;
use Root\Skorikov\Actions\Users\FindByUsername;
use Root\Skorikov\Infrastructure\Http\ErrorResponse;
use Root\Skorikov\Infrastructure\Http\Request;

$container = require __DIR__ . '/bootstrap.php';

$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));

try {
	$path = $request->path();
} catch (HttpException) {
	(new ErrorResponse)->send();
	return;
}

try {
	$method = $request->method();
} catch (HttpException) {
	(new ErrorResponse)->send();
	return;
}

$routes = [
	'GET' => [
		'/users/show' => FindByUsername::class
	],
	'POST' => [
		'/users/create' => CreateUser::class,
		'/posts/create' => CreatePost::class,
		'/posts/comment' => CreateComment::class,
	]
];

if (!array_key_exists($method, $routes)) {
	(new ErrorResponse('Not found'))->send();
	return;
}

if (!array_key_exists($path, $routes[$method])) {
	(new ErrorResponse('Not found'))->send();
	return;
}

$actionClassName = $routes[$method][$path];

$action = $container->get($actionClassName);

try {
	$response = $action->handle($request);
} catch (Exception $error) {
	(new ErrorResponse($error->getMessage()))->send();
}

$response->send();