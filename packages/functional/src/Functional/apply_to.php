<?php declare(strict_types=1);

namespace Tale\Functional;

use Closure;

function apply_to(mixed $value): Closure
{
    return static fn (callable $fn) => $fn($value);
}
