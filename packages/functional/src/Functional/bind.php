<?php declare(strict_types=1);

namespace Tale\Functional;

use Closure;

function bind(callable $fn, object $value): bool|Closure
{
    return Closure::bind($fn instanceof Closure ? $fn : Closure::fromCallable($fn), $value, $value);
}
