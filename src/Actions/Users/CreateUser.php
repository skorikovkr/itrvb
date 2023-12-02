<?php

namespace Root\Skorikov\Actions\Users;

use Root\Skorikov\Exceptions\HttpException;
use Root\Skorikov\Actions\ActionInterface;
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
}