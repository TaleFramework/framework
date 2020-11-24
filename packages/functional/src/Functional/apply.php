<?php declare(strict_types=1);

namespace Tale\Functional;

function apply(callable $fn, iterable $args)
{
    $argArray = unwind($args);
    return $fn(...$argArray);
}
