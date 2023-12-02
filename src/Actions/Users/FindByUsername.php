<?php

namespace Root\Skorikov\Actions\Users;

use Root\Skorikov\Exceptions\HttpException;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Actions\ActionInterface;
use Root\Skorikov\Infrastructure\Http\ErrorResponse;
use Root\Skorikov\Infrastructure\Http\Request;
use Root\Skorikov\Infrastructure\Http\Response;
use Root\Skorikov\Infrastructure\Http\SuccessfulResponse;
use Root\Skorikov\Repositories\Interfaces\UserRepositoryInterface;

class FindByUsername implements ActionInterface
{
	public function __construct(
		private UserRepositoryInterface $userRepository
	)
	{}

	public function handle(Request $request): Response
	{
		try {
			$username = $request->query('username');
		} catch (HttpException $error) {
			return new ErrorResponse($error->getMessage());
		}

		try {
			$user = $this->userRepository->getByUsername($username);
		} catch (UserNotFoundException $error) {
			return new ErrorResponse($error->getMessage());
		}

		return new SuccessfulResponse([
			'username' => $user->getUsername(),
			'name' => (string)$user->getFirstName() + (string)$user->getLastName(),
		]);
	}
}