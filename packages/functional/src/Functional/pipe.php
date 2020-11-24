<?php declare(strict_types=1);

namespace Tale\Functional;

function pipe(callable ...$fns): callable
{
    return static function (...$args) use ($fns) {
        return reduce(fn ($lastArgs, $fn) => [$fn(...$lastArgs)], $args, $fns);
    };
}
