<?php

namespace Root\Skorikov\Infrastructure;

use Root\Skorikov\Exceptions\ArgumentsException;

class Arguments
{
    private array $arguments = [];

    public function __construct(
        iterable $arguments
    )
    {
        foreach ($arguments as $arg => $val) {
            $stringValue = trim((string)$val);
            if (empty($stringValue)) {
                continue;
            }
            $this->arguments[(string)$arg] = $stringValue;
        }
    }

    public static function fromArgv(array $argv): self 
    {
        $arguments = [];
        foreach ($argv as $argument) {
            $parts = explode('=', $argument);
            if (count($parts) !== 2) {
                continue;
            }
            $arguments[$parts[0]] = $parts[1];
        }
        return new self($arguments);
    }

    public function get(string $argument): string
    {
        if (!array_key_exists($argument, $this->arguments)) {
            throw new ArgumentsException("No such argument: $argument");
        }
        return $this->arguments[$argument];
    }
}