<?php

namespace Root\Skorikov\Actions;

use Root\Skorikov\Infrastructure\Http\Request;
use Root\Skorikov\Infrastructure\Http\Response;

interface ActionInterface
{
	public function handle(Request $request): Response;
}