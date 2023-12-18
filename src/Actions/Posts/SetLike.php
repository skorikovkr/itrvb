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
use Root\Skorikov\Models\Post;
use Root\Skorikov\Models\PostLike;
use Root\Skorikov\Repositories\Interfaces\PostLikeRepositoryInterface;
use Root\Skorikov\Repositories\Interfaces\PostRepositoryInterface;

class SetLike implements ActionInterface
{
    public function __construct(
        private PostLikeRepositoryInterface $postLikeRepository
    )
    {}

    public function handle(Request $request): Response
	{
        $newUuid = UUID::random();
        try {
            $entity = new PostLike(
                $newUuid,
                new UUID($request->jsonBodyField('user_uuid')),
                new UUID($request->jsonBodyField('post_uuid')),
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }
        $success = $this->postLikeRepository->save($entity);
        if ($success) {
            return new SuccessfulResponse([
                'uuid' => (string)$newUuid,
            ]);
        } else {
            return new ErrorResponse('Cannot set like.');
        }
    }
}