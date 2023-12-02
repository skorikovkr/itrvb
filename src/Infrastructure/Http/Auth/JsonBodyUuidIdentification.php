<?php

namespace Root\Skorikov\Infrastructure\Http\Auth;

use InvalidArgumentException;
use Root\Skorikov\Exceptions\AuthException;
use Root\Skorikov\Exceptions\HttpException;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Infrastructure\Http\Request;
use Root\Skorikov\Models\User;
use Root\Skorikov\Repositories\Interfaces\UserRepositoryInterface;

class JsonBodyUuidIdentification implements IdentificationInterface
{
	public function __construct(
		private UserRepositoryInterface $userRepository
	)
	{}

	public function user(Request $request): User
	{
		try {
			$username = $request->jsonBodyField('username');
		} catch (HttpException|InvalidArgumentException $error) {
			throw new AuthException($error->getMessage());
		}

		try {
			return $this->userRepository->getByUsername($username);
		} catch (UserNotFoundException $error) {
			throw new AuthException($error->getMessage());
		}
	}
}