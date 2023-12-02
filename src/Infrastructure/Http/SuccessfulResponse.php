<?php
namespace Root\Skorikov\Infrastructure\Http;

class SuccessfulResponse extends Response
{
	protected const SUCCEESS = true;

	public function __construct(
		private array $data = []
	)
	{
		
	}

	protected function payload(): array
	{
		return ['data' => $this->data];
	}
}