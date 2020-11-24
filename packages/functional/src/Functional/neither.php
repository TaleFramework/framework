<?php declare(strict_types=1);

namespace Tale\Functional;

use Closure;

function neither(callable $lhs, callable $rhs): Closure
{
    return static fn ($value) => !$lhs($value) && !$rhs($value);
}
