<?php

namespace Root\Skorikov\Infrastructure\Http\Auth;

use Root\Skorikov\Infrastructure\Http\Request;
use Root\Skorikov\Models\User;

interface IdentificationInterface
{
	public function user(Request $request): User;
}