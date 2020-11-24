<?php declare(strict_types=1);

namespace Tale\Functional;

function compose(callable ...$fns): callable
{
    return static function (...$args) use ($fns) {
        return reduce_right(fn ($lastArgs, $fn) => [$fn(...$lastArgs)], $args, $fns);
    };
}
