<?php

namespace Root\Skorikov\Actions\Users;

use Root\Skorikov\Exceptions\HttpException;
use Root\Skorikov\Actions\ActionInterface;
use Root\Skorikov\Exceptions\CommandException;
use Root\Skorikov\Exceptions\UserNotFoundException;
use Root\Skorikov\Infrastructure\Http\ErrorResponse;
use Root\Skorikov\Infrastructure\Http\Request;
use Root\Skorikov\Infrastructure\Http\Response;
use Root\Skorikov\Infrastructure\Http\SuccessfulResponse;
use Root\Skorikov\Repositories\Interfaces\UserRepositoryInterface;
use Root\Skorikov\Models\User;
use Root\Skorikov\Infrastructure\UUID;

class CreateUser implements ActionInterface
{
  public function __construct(
    private UserRepositoryInterface $usersRepository
  )
  {
  }

  public function handle(Request $request): Response
  {
    $username = $request->jsonBodyField('username');
		if ($this->userExisit($username)) {
			throw new CommandException(
				"User already exists: $username"
			);
		}
    try {
      $newUserUuid = UUID::random();
      $user = new User(
        $newUserUuid,
        $request->jsonBodyField('first_name'),
        $request->jsonBodyField('last_name'),
				$request->jsonBodyField('username')
      );
    } catch (HttpException $exception) {
      return new ErrorResponse($exception->getMessage());
    }
    $this->usersRepository->save($user);
    return new SuccessfulResponse([
      'uuid' => (string)$newUserUuid
    ]);
  }

	public function userExisit(string $username): bool
	{
		try {
			$this->usersRepository->getByUsername($username);
		} catch (UserNotFoundException) {
			return false;
		}
		return true;
	}
}