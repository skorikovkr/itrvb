<?php

namespace Root\Skorikov\Tests;

use PHPUnit\Framework\TestCase;
use Root\Skorikov\Actions\Posts\CreatePost;
use Root\Skorikov\Exceptions\ArgumentsException;
use Root\Skorikov\Exceptions\PostNotFoundException;
use Root\Skorikov\Infrastructure\Arguments;
use Root\Skorikov\Infrastructure\Http\Auth\IdentificationInterface;
use Root\Skorikov\Infrastructure\Http\ErrorResponse;
use Root\Skorikov\Infrastructure\Http\Request;
use Root\Skorikov\Infrastructure\Http\SuccessfulResponse;
use Root\Skorikov\Infrastructure\SqliteTestConnector;
use Root\Skorikov\Infrastructure\UUID;
use Root\Skorikov\Models\Comment;
use Root\Skorikov\Models\Post;
use Root\Skorikov\Models\User;
use Root\Skorikov\Repositories\CommentRepository\SqliteCommentRepository;
use Root\Skorikov\Repositories\Interfaces\PostRepositoryInterface;

class DummyPostsRepository implements PostRepositoryInterface
{
    public function __construct(
        public array $posts
    ) 
    {}

    public function save(Post $post): void
    {
        $this->posts []= $post;
    }

    public function get(UUID $uuid): Post
    {
        foreach ($this->posts as $post) {
            if ($post->getUuid()->__toString() != $uuid->__toString()) {
                return $post;
            }
        }
        throw new PostNotFoundException();
    }

    public function delete(UUID $uuid): void
    {
        $result = [];
        foreach ($this->posts as $post) {
            if ($post->getUuid()->__toString() != $uuid->__toString()) {
                $result []= $post;
            }
        }
        $this->posts = $result;
    }
}

class DummyIdentification implements IdentificationInterface
{
    public function __construct(
        private User $user
    ) 
    {}

	public function user(Request $request): User {
        return $this->user;
    }
}

final class CreatePostTest extends TestCase {
	/**
     * @runInSeparateProcess
     * @preserveGlobalState disable
	 * @throws JsonException
   */
	public function testItReturnSuccessfulResponse(): void
	{
        $testUser = new User(
            UUID::random(),
            "username1",
            "username1",
            "username1",
        );
		$request = new Request([], [], '{"username":"' . $testUser->getUsername() . '","title":"title","text":"text"}');

		$userRepository = new DummyPostsRepository([]);

		$action = new CreatePost($userRepository, new DummyIdentification($testUser));

		$response = $action->handle($request);

		$this->assertInstanceOf(SuccessfulResponse::class, $response);
		$this->expectOutputString('{"success":true,"data":{"uuid":"' . $userRepository->posts[0]->getUuid() . '"}}');

		$response->send();
	}

    // 2. класс возвращает ошибку, если запрос содержит UUID в неверном
    // формате;
    // 3. класс возвращает ошибку, если пользователь не найден по этому
    // UUID;
    // ЭТИХ ТЕСТОВ НЕТ, Т.К. ПРИ СОЗДАНИИ ПРИНИМАЕТСЯ USERNAME, А НЕ ЕГО UUID
    // ПОКРЫТИЕ ЭТОГО КЛАССА ВСЕ РАВНО 100%

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
	 * @throws JsonException
   */
	public function testItReturnExceptionOnNoSuchField(): void
	{
        $testUser = new User(
            UUID::random(),
            "username1",
            "username1",
            "username1",
        );
		$request = new Request([], [], '{"username":"' . $testUser->getUsername() . '","text":"text"}');

		$userRepository = new DummyPostsRepository([]);

		$action = new CreatePost($userRepository, new DummyIdentification($testUser));

		$response = $action->handle($request);

		$this->assertInstanceOf(ErrorResponse::class, $response);
		$this->expectOutputString('{"success":true,"reason":"No such field: title"}');

		$response->send();
	}
}