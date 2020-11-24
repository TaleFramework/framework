<?php declare(strict_types=1);

namespace Tale\Functional;

use Closure;

function always($value): Closure
{
    return static fn() => $value;
}
