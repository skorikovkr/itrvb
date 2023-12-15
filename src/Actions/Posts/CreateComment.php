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
use Root\Skorikov\Models\Comment;
use Root\Skorikov\Repositories\Interfaces\CommentRepositoryInterface;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentRepositoryInterface $repository,
        private IdentificationInterface $identification
    )
    {}

    public function handle(Request $request): Response
	{
        //$user = $this->identification->user($request);
        $newUuid = UUID::random();
        try {
            $entity = new Comment(
                $newUuid,
                new UUID($request->jsonBodyField('author_uuid')),
                new UUID($request->jsonBodyField('post_uuid')),
                $request->jsonBodyField('text'),
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }
        $this->repository->save($entity);
        return new SuccessfulResponse([
            'uuid' => (string)$newUuid,
        ]);
    }
}