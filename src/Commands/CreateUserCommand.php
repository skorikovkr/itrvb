<?php

namespace Root\Skorikov\Commands;

use Root\Skorikov\Exceptions\CommandException;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Infrastructure\Arguments;
use Root\Skorikov\Repositories\Interfaces\UserRepositoryInterface;
use Root\Skorikov\Models\User;
use Root\Skorikov\Infrastructure\UUID;

class CreateUserCommand
{
	public function __construct(
		private UserRepositoryInterface $userRepository,
	)
	{}

	public function handle(Arguments $arguments): void
	{
		$username = $arguments->get('username');
		if ($this->userExisit($username)) {
			throw new CommandException(
				"User already exists: $username"
			);
		}
		$this->userRepository->save(new User(
			UUID::random(),
			$arguments->get('first_name'),
		 	$arguments->get('last_name'),
			$username
		));
	}

	public function userExisit(string $username): bool
	{
		try {
			$user = $this->userRepository->getByUsername($username);
		} catch (UserNotFoundException) {
			return false;
		}
		return true;
	}
}