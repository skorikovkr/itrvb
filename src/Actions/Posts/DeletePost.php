<?php

namespace Root\Skorikov\Actions\Posts;

use Root\Skorikov\Actions\ActionInterface;
use Root\Skorikov\Exceptions\HttpException;
use Root\Skorikov\Infrastructure\Http\Auth\IdentificationInterface;
use Root\Skorikov\Infrastructure\Http\ErrorResponse;
use Root\Skorikov\Infrastructure\Http\Request;
use Root\Skorikov\Infrastructure\Http\Response;
use Root\Skorikov\Infrastructure\Http\SuccessfulResponse;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Repositories\Interfaces\PostRepositoryInterface;

class DeletePost implements ActionInterface
{
    public function __construct(
        private PostRepositoryInterface $repository,
        private IdentificationInterface $identification
    )
    {}

    public function handle(Request $request): Response
	{
        //$user = $this->identification->user($request);
        try {
            $this->repository->delete(new UUID($request->query('uuid')));
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }
        return new SuccessfulResponse([
            'uuid' => $request->query('uuid'),
        ]);
    }
}