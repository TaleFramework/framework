<?php declare(strict_types=1);

namespace Tale\Functional;

use Closure;

function both(callable $a, callable $b): Closure
{
    return static fn ($value) => $a($value) && $b($value);
}
