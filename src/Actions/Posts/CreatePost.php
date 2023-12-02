<?php

use Root\Skorikov\Actions\ActionInterface;
use Root\Skorikov\Exceptions\HttpException;
use Root\Skorikov\Infrastructure\Http\Auth\IdentificationInterface;
use Root\Skorikov\Infrastructure\Http\ErrorResponse;
use Root\Skorikov\Infrastructure\Http\Request;
use Root\Skorikov\Infrastructure\Http\Response;
use Root\Skorikov\Infrastructure\Http\SuccessfulResponse;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\Post;
use Root\Skorikov\Repositories\Interfaces\PostRepositoryInterface;

class CreatePost implements ActionInterface
{
    public function __construct(
        private PostRepositoryInterface $postsRepository,
        private IdentificationInterface $identification
    )
    {}

    public function handle(Request $request): Response
	{
        $user = $this->identification->user($request);
        $newPostUuid = UUID::random();
        try {
            $post = new Post(
                $newPostUuid,
                $user->getUuid(),
                $request->jsonBodyField('title'),
                $request->jsonBodyField('text')
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->save($post);
        return new SuccessfulResponse([
            'uuid' => (string)$newPostUuid,
        ]);
    }
}