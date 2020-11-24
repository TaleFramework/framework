<?php declare(strict_types=1);

namespace Tale\Functional;

function call(callable $fn, ...$args)
{
    $argArray = unwind($args);
    return $fn(...$argArray);
}
